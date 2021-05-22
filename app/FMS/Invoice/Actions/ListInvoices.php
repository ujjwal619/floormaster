<?php

namespace App\FMS\Invoice\Actions;

use App\FMS\Site\Traits\FilterSiteByUserTrait;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ListInvoices extends AdminController
{
    use FilterSiteByUserTrait;

    public function __construct()
    {
        $this->middleware(['permission:billing.access']);
    }

    public function __invoke(Request $request)
    {
        $jobId = $request->get('job_id');
        $user = $request->user();
        $isSuperUser = $user->hasRole('super_admin');

        $from = getDateRange($isSuperUser, 'start'); 
        $to = getDateRange($isSuperUser, 'end'); 

        $invoices = $this->filterSiteByUser($user)
            ->join('tbl_jobs', 'tbl_jobs.site_id', 'sites.id')
            ->join('tbl_job_invoices', 'tbl_job_invoices.job_id', 'tbl_jobs.id')
            ->select(
                'tbl_job_invoices.id as id',
                'tbl_job_invoices.date as date',
                'tbl_job_invoices.amount as amount',
                'tbl_job_invoices.id as id',
                'tbl_jobs.job_id as job_no',
                'tbl_jobs.trading_name as job_trading_name',
                'tbl_jobs.project as job_project'
            )
            ->whereBetween('tbl_job_invoices.date', [$from, $to]);

        if ($jobId) {
            $invoices->where('tbl_jobs.id', $jobId);
        }
            
        $invoices = $invoices
            ->orderBy('tbl_job_invoices.updated_at', 'DESC')
            ->get();

        return $this->sendSuccessResponse($invoices->toArray());
    }
}
