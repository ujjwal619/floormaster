<?php

namespace App\FMS\Supplier\Actions;

use App\FMS\Site\Traits\FilterSiteByUserTrait;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ListPayables extends AdminController
{
    use FilterSiteByUserTrait;

    public function __invoke(Request $request)
    {
        $user = $request->user();
        $site = $request->get('site_id');
        $supplier = $request->get('supplier_id');
        $customer = $request->get('customer_id');
        $job = $request->get('job_id');

        $data = $this->filterSiteByUser($user)
            ->join('supplier_payables', 'supplier_payables.site_id', 'sites.id')
            ->leftJoin('tbl_jobs', 'tbl_jobs.id', 'supplier_payables.job_id')
            ->join('tbl_suppliers', 'tbl_suppliers.id', 'supplier_payables.supplier_id')
            ->leftJoin('tbl_customers', 'tbl_customers.id', 'supplier_payables.client')
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
                'supplier_payables.created_at as created_at',
                'tbl_suppliers.trading_name as supplier_trading_name',
                'tbl_jobs.job_id as job_no'
            );

        if ($site) {
            $data = $data->where('supplier_payables.site_id', $site);
        }

        if ($supplier) {
            $data = $data->where('supplier_payables.supplier_id', $supplier);
        }

        if ($job) {
            $data = $data->where('supplier_payables.job_id', $job);
        }

        if ($customer) {
            $data = $data->where('supplier_payables.client', $customer);
        }

        $data = $data
            ->latest()
            // ->groupBy('tbl_future_stocks.id')
            ->get();

        return $this->sendSuccessResponse($data->toArray());
    }
}
