<?php

namespace App\FMS\Supplier\Actions;

use App\FMS\Site\Models\Site;
use App\FMS\Supplier\Models\Payable;
use App\StartUp\BaseClasses\Controller\AdminController;

class ListSupplierPayablesBySite extends AdminController
{
    public function __invoke(Site $site, Payable $payable)
    {
        $payables = $payable->newQuery()
            ->join('tbl_suppliers', 'tbl_suppliers.id', 'supplier_payables.supplier_id')
            ->leftJoin('tbl_jobs', 'tbl_jobs.id', 'supplier_payables.job_id')
            ->where('supplier_payables.site_id', $site->id)
            ->where('supplier_payables.is_paid', false)
            ->select(
                'supplier_payables.id as id',
                'supplier_payables.site_id as site_id',
                'supplier_payables.supplier_id as supplier_id',
                'supplier_payables.job_id as job_id',
                'supplier_payables.supplier_reference as supplier_reference',
                'supplier_payables.client as client',
                'supplier_payables.expected_amount as expected_amount',
                'supplier_payables.invoice_amount as invoice_amount',
                'supplier_payables.order_no as order_no',
                'tbl_suppliers.trading_name as supplier_trading_name',
                'tbl_jobs.job_id as job_no'
            )
            ->get()
            ->toArray();

        return $this->sendSuccessResponse($payables);
    }
}
