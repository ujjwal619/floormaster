<?php

namespace App\FMS\Remittance\Actions;

use App\FMS\CashBook\Manager;
use App\FMS\CashBookTypes;
use App\FMS\Remittance\Events\PaidToContractor;
use App\FMS\Remittance\Events\PaidToSupplier;
use App\FMS\Remittance\Models\Remittance;
use App\FMS\Remittance\ValueObjects\PaymentType;
use App\StartUp\BaseClasses\Controller\AdminController;
use Exception;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RemitRemittance extends AdminController
{
    public function __invoke(
        Remittance $remittance, 
        Request $request,
        Manager $cashBookManager,
        DatabaseManager $databaseManager
    ) {
        //TODO: date range validation
        $request->validate([
            'items' => 'array',
        ]);

        $remittance->load(['payItems.payable.site', 'payItems.paymentDue.site']);

        return $databaseManager->transaction(function() use (
            $remittance, 
            $databaseManager,
            $cashBookManager
        ) {
            try {
                $items = $remittance->payItems;
                $remittance->fill(['is_paid' => true])->save();
        
                $totalPayableAmount = 0;

                foreach($items as $item) {
                    $item->fill(['is_paid' => true])->save();
                    $totalPayableAmount += $item->gross_payment;

                    if($item->payable) {
                        throw_if($item->payable->is_paid, new Exception('Remittance is already Paid.'));
                        $item->payable->fill(['is_paid' => true])->save();
                    } 
                    if($item->paymentDue) {
                        throw_if($item->paymentDue->is_paid, new Exception('Remittance is already Paid.'));
                        $item->paymentDue->fill(['is_paid' => true])->save();
                    }
                }

                $cashBookDetails = [
                    'payee' => $remittance->payee_name ?? '',
                    'type' => CashBookTypes::DEBIT,
                    'date' => $remittance->transaction_date ?? $remittance->cheque_date,
                    'net_amount' => $totalPayableAmount,
                    'payment_type' =>  $remittance->payment_type === PaymentType::EFT ? 'EFT' : 'Cheque',
                    'site_id' => $remittance->site_id,
                    'eft_cheque' => $remittance->remittance_number,
                    'remit_id' => $remittance->id
                ];
    
                $cashBook = $cashBookManager->createCashBook($cashBookDetails);

                if ($remittance->contractor_id) {
                    event(new PaidToContractor($remittance, $cashBook, $totalPayableAmount));
                } 
                if ($remittance->supplier_id) {
                    event(new PaidToSupplier($remittance, $cashBook, $totalPayableAmount));
                }

                $databaseManager->commit();
        
                return $this->sendSuccessResponse([], 'Successfully remitted remittance.');
            } catch(\Exception $exception) {
                $databaseManager->rollback();
                dd($exception);
                return $this->sendError('Could not remit remittance.', Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        });        
    }
}
