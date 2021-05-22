<?php

namespace App\FMS\Job\Actions;

use App\FMS\Site\Traits\FilterSiteByUserTrait;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ListJob extends AdminController
{
    use FilterSiteByUserTrait;

    public function __invoke(Request $request)
    {
        $user = $request->user();
        $site = $request->get('site_id');
        // $supplier = $request->get('supplier_id');
        $customer = $request->get('customer_id');

        $data = $this->filterSiteByUser($user)
            ->join('tbl_jobs', 'tbl_jobs.site_id', 'sites.id')
            ->leftJoin('tbl_customers', 'tbl_customers.id', 'tbl_jobs.customer_id')
            ->select(
                'tbl_jobs.id as id',
                'tbl_jobs.job_id as job_id',
                'tbl_jobs.created_at as created_at'
            );

        if ($site) {
            $data = $data->where('tbl_jobs.site_id', $site);
        }

        if ($customer) {
            $data = $data->where('tbl_jobs.customer_id', $customer);
        }

        $data = $data
            ->latest()
            // ->groupBy('tbl_future_stocks.id')
            ->get();

        return $this->sendSuccessResponse($data->toArray());
    }
}
