<?php

namespace App\FMS\Invoice\Actions;

use App\FMS\Site\Traits\FilterSiteByUserTrait;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class IndexInvoice extends AdminController
{
    use FilterSiteByUserTrait;

    public function __construct()
    {
        $this->middleware(['permission:billing.access']);
    }

    public function __invoke(Request $request)
    {
        $user = $request->user();

        $invoice = $this->filterSiteByUser($user)
            ->join('tbl_jobs', 'tbl_jobs.site_id', 'sites.id')
            ->join('tbl_job_invoices', 'tbl_job_invoices.job_id', 'tbl_jobs.id')
            ->select(
                'tbl_job_invoices.id as id'
            )
            ->orderBy('tbl_job_invoices.updated_at', 'DESC')
            ->first();

        return $this->sendSuccessResponse($invoice ? $invoice->toArray() : []);
    }
}
