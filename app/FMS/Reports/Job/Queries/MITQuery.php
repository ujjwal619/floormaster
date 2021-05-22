<?php

namespace App\FMS\Reports\Job\Queries;

use App\FMS\Filters\AdvanceQueryFilter;
use App\FMS\Site\Traits\FilterSiteByUserTrait;
use Illuminate\Database\Query\Expression;
use Illuminate\Http\Request;

class MITQuery
{
    use FilterSiteByUserTrait;

    public function run(Request $request)
    {
        return $this->getFilteredMIT($request, false)
            ->paginate($request->get('per_page', config('fms.paginationLimit')));
    }

    public function export(Request $request, $returnNumeric = false)
    {
        return $this->getFilteredMIT($request, $returnNumeric)
            ->get();
    }

    private function getFilteredMIT(Request $request, $returnNumeric = false)
    {
        $user = $request->user();
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        return $this->filterSiteByUser($user)
            ->join('tbl_jobs', 'tbl_jobs.site_id', 'sites.id')
            ->join('tbl_job_receipts', 'tbl_job_receipts.job_id','tbl_jobs.id')
            ->select(
                'tbl_job_receipts.invoice_id as invoice_id',
                'tbl_jobs.job_id as job',
                'tbl_jobs.trading_name as client',
                'sites.name as store_name',
                'tbl_job_receipts.receipt_date as receipt_date',
                'tbl_job_receipts.notation as reference',
                new Expression('
                    if(tbl_job_receipts.invoice_id is NULL,
                        0,
                        if("'.$returnNumeric.' = TRUE", 
                            tbl_job_receipts.amount, 
                            CONCAT("$", tbl_job_receipts.amount)
                        )
                    ) as allocated
                '),
                new Expression('
                    if(tbl_job_receipts.invoice_id is NULL,
                        if("'.$returnNumeric.' = TRUE", 
                            tbl_job_receipts.amount, 
                            CONCAT("$", tbl_job_receipts.amount)
                        ),
                        0
                    ) as non_allocated
                ')
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
                'job',
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
