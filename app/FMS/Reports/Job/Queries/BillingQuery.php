<?php

namespace App\FMS\Reports\Job\Queries;

use App\FMS\Filters\AdvanceQueryFilter;
use App\FMS\Site\Traits\FilterSiteByUserTrait;
use Illuminate\Database\Query\Expression;
use Illuminate\Http\Request;

class BillingQuery
{
    use FilterSiteByUserTrait;

    public function run(Request $request)
    {
        return $this->getFilteredBillings($request, true)
            ->paginate($request->get('per_page', config('fms.paginationLimit')));
    }

    public function export(Request $request, $returnNumeric = false)
    {
        return $this->getFilteredBillings($request, $returnNumeric)
            ->get();
    }

    private function getFilteredBillings(Request $request, $returnNumeric = false)
    {
        $user = $request->user();
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        return $this->filterSiteByUser($user)
            ->join('tbl_jobs', 'tbl_jobs.site_id', 'sites.id')
            ->join('tbl_job_invoices', 'tbl_job_invoices.job_id','tbl_jobs.id')
            ->join('pivot_jobs_sales', 'pivot_jobs_sales.id','tbl_jobs.id')
            ->join('sales_staff', 'sales_staff.id', 'pivot_jobs_sales.sales_id')
            ->select(
                new Expression('CONCAT(tbl_jobs.job_id, "/", tbl_job_invoices.id) as invoice_no'),
                'sites.name as site_name',
                'tbl_job_invoices.date as invoice_date',
                new Expression(
                    "if('tbl_job_invoices.amount > 0', 'Tax Invoice', 'Tax Credit') as invoice_type"
                ),
                'tbl_jobs.trading_name as client',
                'tbl_jobs.project as project',
                new Expression('
                    if("'.$returnNumeric.' = 1", 
                        tbl_job_invoices.net_invoice, 
                        CONCAT("$",tbl_job_invoices.net_invoice)
                    ) as net_invoice
                '),
                new Expression('
                    if("'.$returnNumeric.' = 1", 
                        tbl_job_invoices.gst_amount, 
                        CONCAT("$",tbl_job_invoices.gst_amount)
                    ) as gst_amount
                '),
                new Expression('
                    if("'.$returnNumeric.' = 1", 
                        ROUND(tbl_job_invoices.amount, 2), 
                        CONCAT("$",ROUND(tbl_job_invoices.amount, 2))
                    ) as gross_amount
                '),
                new Expression('
                    if("'.$returnNumeric.' = 1", 
                        tbl_job_invoices.balance_due, 
                        CONCAT("$",tbl_job_invoices.balance_due)
                    ) as balance_due
                '),
                'sales_staff.name as sales_staff'
            )
            ->where('pivot_jobs_sales.priority','primary')
            ->whereBetween('date', [$startDate, $endDate])
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
                'invoice_date' => 'tbl_job_invoices.date', 
                'store_name' => 'sites.name',               
            ],
            'having' => [
            ],
        ];
    }
}
