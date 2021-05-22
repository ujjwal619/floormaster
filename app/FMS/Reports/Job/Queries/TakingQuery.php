<?php

namespace App\FMS\Reports\Job\Queries;

use App\FMS\Filters\AdvanceQueryFilter;
use App\FMS\Site\Traits\FilterSiteByUserTrait;
use Illuminate\Database\Query\Expression;
use Illuminate\Http\Request;

class TakingQuery
{
    use FilterSiteByUserTrait;

    public function run(Request $request)
    {
        return $this->getFilteredTakings($request, false)
            ->paginate($request->get('per_page', config('fms.paginationLimit')));
    }

    public function export(Request $request, $returnNumeric = false)
    {
        return $this->getFilteredTakings($request, $returnNumeric)
            ->get();
    }

    private function getFilteredTakings(Request $request, $returnNumeric = false)
    {
        $user = $request->user();
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        return $this->filterSiteByUser($user)
            ->join('tbl_jobs', 'tbl_jobs.site_id', 'sites.id')
            ->join('tbl_job_invoices', 'tbl_job_invoices.job_id','tbl_jobs.id')
            ->join('tbl_job_receipts', 'tbl_job_receipts.invoice_id','tbl_job_invoices.id')
            ->select(
                new Expression('CONCAT(tbl_jobs.job_id, "/", tbl_job_invoices.id) as invoice_no'),
                'sites.name as store_name',
                'tbl_job_receipts.receipt_date as receipt_date',
                new Expression(
                    "if('".$returnNumeric." = TRUE', tbl_job_receipts.amount, CONCAT('$', tbl_job_receipts.amount)) as amount"
                ),
                'tbl_job_receipts.notation as reference',
                'tbl_jobs.trading_name as client',
                'tbl_jobs.project as project'
            )
            ->whereBetween('tbl_job_receipts.receipt_date', [$startDate, $endDate])
            ->filter($this->getFilter());
    }

    private function getFilter()
    {
        // @var AdvanceQueryFilter
        $filter = app(AdvanceQueryFilter::class);

        $filter->setFilterableColumns($this->getFilterableColumns())
            ->setSortableColumns([
                'invoice_no',
            ]);

        return $filter;
    }

    private function getFilterableColumns()
    {
        return [
            'where' => [
                'receipt_date' => 'tbl_job_receipts.receipt_date', 
                'store_name' => 'sites.name',               
            ],
            'having' => [
            ],
        ];
    }
}
