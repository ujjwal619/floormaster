<?php

namespace App\FMS\Remittance;

use App\FMS\Remittance\Models\Remittance;
use App\FMS\Remittance\Models\RemittanceItem;
use App\FMS\Remittance\ValueObjects\PaymentType;
use App\FMS\Remittance\ValueObjects\RemittanceType;
use App\FMS\Supplier\Models\Payable;
use Exception;
use Illuminate\Database\DatabaseManager;

class Manager
{
    private $remittance;
    private $contractorManager;
    private $databaseManager;
    private $supplierManager;

    public function __construct(
        Remittance $remittance,
        \App\FMS\Contractor\Manager $contractorManager,
        DatabaseManager $databaseManager,
        \App\FMS\Supplier\Manager $supplierManager
    ) {
        $this->remittance = $remittance;
        $this->contractorManager = $contractorManager;
        $this->databaseManager = $databaseManager;
        $this->supplierManager = $supplierManager;
    }

    public function find(int $id)
    {
        return $this->remittance->newQuery()->with(['items', 'contractor', 'supplier'])->find($id);
    }

    public function create(int $siteId, array $details)
    {
        $details['site_id' ] = $siteId;
        try{
            $this->databaseManager->beginTransaction();

            if ($details['remittance_type'] === RemittanceType::MANUAL_PAY) {
                unset($details['supplier_id']);
                unset($details['contractor_id']);
            }
            $contractorId = array_get($details, 'contractor_id');
            $supplierId = array_get($details, 'supplier_id');
            $contractor = null;
            $supplier = null;

            if ($contractorId) {
                $contractor = $this->contractorManager->find($contractorId);
            }

            if ($supplierId) {
                $supplier = $this->supplierManager->find($supplierId);
            }

            if (!array_get($details, 'payee_name')) {
                if ($supplier) {
                    $details['payee_name'] = $supplier->trading_name;
                    $details['payee_street'] = $supplier->street;
                    $details['payee_town'] = $supplier->suburb;
                    $details['payee_state'] = $supplier->state;
                    $details['payee_code'] = $supplier->code;
                }

                if ($contractor) {
                    $details['payee_name'] = $contractor->name;
                    $details['payee_street'] = $contractor->street;
                    $details['payee_town'] = $contractor->suburb;
                    $details['payee_state'] = $contractor->state;
                    $details['payee_code'] = $contractor->postcode;
                }
            }

            $remittance = $this->remittance->newInstance()->create($details);
            
            $remittance->fill([
                'remittance_number' => $remittance->payment_type === PaymentType::EFT ? 'E' . $remittance->id : $remittance->cheque_number
            ])->save();

            if ($contractor) {
                foreach ($contractor->payments as $payment) {
                    // dd($payment->date, $details['pay_up_to']);

                    if($payment->date > $details['pay_up_to']) {
                        continue;
                    }
                    $gstAmount = ($payment->amount * $payment->gst) / 100;
                    $remittanceItemDetail = [
                        'goods' => $payment->amount,
                        'gst' => $gstAmount,
                        'comments' => $payment->job->trading_name,
                        'invoice_amount' => $payment->amount + $gstAmount,
                        'order_no' => 1212,
                        'supplier_reference' => $payment->job->job_id,
                        'payment_due_id' => $payment->id,
                        'job' => $payment->job_id,
                        'default_item_status' => $remittance->default_item_status,
                    ];
                    $this->createItem($remittance, $remittanceItemDetail);
                }
            }

            if ($supplier) {
                if ($details['remittance_type'] === RemittanceType::PAY_THIS_RECORD) {
                    $payable = $supplier->payables->firstWhere('id', $details['payable_id']);
                    throw_if(!$payable, new Exception('Remittance is already Paid.'));
                    $remittanceItemDetail = $this->setRemittanceItemDetail($payable, $remittance);
                    $this->createItem($remittance, $remittanceItemDetail);
                } else {
                    foreach ($supplier->payables as $key => $payable) {
                        if($payable->invoice_date > $details['invoice_date']) {
                            continue;
                        }
    
                        $remittanceItemDetail = $this->setRemittanceItemDetail($payable, $remittance);
                        $this->createItem($remittance, $remittanceItemDetail);
                    }
                }
            }

            $this->databaseManager->commit();
            return $remittance;
        } catch (\Exception $exception) {
            $this->databaseManager->rollBack();
            throw new \Exception($exception->getMessage());
        }
    }

    private function setRemittanceItemDetail(Payable $payable, Remittance $remittance)
    {
        return  [
            'order_no' => $payable->order_no,
            'supplier_reference' => $payable->supplier_reference,
            'invoice_amount' => $payable->invoice_amount,
            'goods' => $payable->goods,
            'freight' => $payable->freight,
            'levy' => $payable->levy,
            'gst' => $payable->gst,
            'adjustment' => $payable->adjustment,
            'net_payment' => $payable->expected_amount,
            'comments' => $payable->comments,
            'goods_cost_ac' => $payable->cost_account,
            'freight_cost_ac' => $payable->liabitity_account,
            'levy_cost_ac' => $payable->levy_account,
            'payable_id' => $payable->id,
            'job' => $payable->job_id,
            'default_item_status' => $remittance->default_item_status,
        ];
    }

    public function update(Remittance $remittance, array $details)
    {
        $remittance->fill($details)->save();
        return $remittance;
    }

    public function updateRemittanceItem(
        RemittanceItem $remittanceItem, 
        array $details
    ) {
        $remittanceItem->fill($details)->save();
        return $remittanceItem;
    }

    public function createItem(Remittance $remittance, array $details)
    {
        $details['gross_payment'] = array_get($details, 'goods') + array_get($details, 'freight')
        + array_get($details, 'levy') + array_get($details, 'gst');

        $details['adjustment'] = $details['gross_payment'] - array_get($details, 'invoice_amount');

        $discount = (array_get($details, 'invoice_amount') * array_get($details, 'discount')) / 100;

        $details['net_payment'] = $details['gross_payment'] - $discount - $details['gst'];
        
        try {
            $remittance->items()->create($details);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}
