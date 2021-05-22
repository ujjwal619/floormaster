<?php

namespace App\FMS\Supplier;

use App\Data\Entities\Models\Supplier\Supplier;
use App\FMS\Site\Traits\FilterSiteByUserTrait;
use App\FMS\Supplier\Events\PayableCreated;
use App\FMS\User\Models\User;
use Illuminate\Database\DatabaseManager;

class Manager
{
    use FilterSiteByUserTrait;

    private $supplier;
    private $databaseManager;

    public function __construct(
        Supplier $supplier,
        DatabaseManager $databaseManager
    ) {
        $this->supplier = $supplier;
        $this->databaseManager = $databaseManager;
    }

    public function find(int $id)
    {
        return $this->supplier->with(['site'])->find($id);
    }

    public function findLatest(User $user)
    {
        return $this->filterSiteByUser($user)
            ->join('tbl_suppliers', 'tbl_suppliers.site_id', 'sites.id')
            ->select('tbl_suppliers.id as id')
            ->whereNull('tbl_suppliers.deleted_at')
            ->orderBy('tbl_suppliers.updated_at', 'DESC')
            ->first();
    }

    public function getBySite(int $siteId)
    {

    }

    public function findWhere(array $conditions = [])
    {
        return $this->supplier->where($conditions)->first();
    }

    public function savePayable(
        Supplier $supplier, 
        array $details, 
        bool $isFromFutureStockInvoice = false
    ) {
        $details['expected_amount'] = array_get($details, 'goods', 0) + array_get($details, 'freight', 0) + array_get($details, 'levy', 0) + array_get($details, 'gst', 0);
        $details['adjustment'] = $details['expected_amount'] - $details['invoice_amount'];
        $details['site_id'] = $supplier->site_id;
        $details['date_delivered'] = array_get($details, 'date_delivered', $details['invoice_date']);
        $details['levy_account'] = $details['levy_account'] ?? $supplier->levy_account;
        $details['cost_account'] = $details['cost_account'] ?? $supplier->default_cost_account;
        $details['liability_account'] = $details['liability_account'] ?? $supplier->site->trade_creditors_id;

        $supplier->load('central_billing');

        if ($supplier->central_billing) {
            $supplier = $supplier->central_billing()->first();
        }

        return $this->databaseManager->transaction(function() use(
            $supplier, 
            $details,
            $isFromFutureStockInvoice
        ) {
            try {
                $payable = $supplier->payables()->create($details);

                if (!$isFromFutureStockInvoice) {
                    event(new PayableCreated($payable));
                }
                $this->databaseManager->commit();

                return $payable;
            } catch (\Exception $exception) {
                $this->databaseManager->rollback();
            }
        });   
    }
}
