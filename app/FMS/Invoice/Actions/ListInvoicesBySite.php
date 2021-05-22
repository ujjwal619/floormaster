<?php

namespace App\FMS\Invoice\Actions;

use App\Data\Entities\Models\Job\Invoice;
use App\FMS\Site\Models\Site;
use App\StartUp\BaseClasses\Controller\AdminController;

class ListInvoicesBySite extends  AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:billing.access']);
    }
    
    public function __invoke(Site $site, Invoice $invoice)
    {
        $invoices = $invoice->newQuery()
            ->join('tbl_jobs', 'tbl_job_invoices.job_id', 'tbl_jobs.id')
            ->where('tbl_jobs.site_id', $site->id)
            ->select(
                'tbl_job_invoices.id as id',
                'tbl_jobs.job_id as job_no',
                'tbl_jobs.trading_name as job_trading_name',
                'tbl_jobs.project as job_project'
            )
            ->orderBy('tbl_job_invoices.updated_at', 'DESC')
            ->get();

        return $this->sendSuccessResponse($invoices->toArray());
    }
}
