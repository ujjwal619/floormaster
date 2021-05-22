<?php

namespace App\FMS\Reports\Job\Queries;

use App\FMS\Filters\AdvanceQueryFilter;
use App\FMS\Site\Traits\FilterSiteByUserTrait;
use Illuminate\Database\Query\Expression;
use Illuminate\Http\Request;

class CommissionQuery
{
    use FilterSiteByUserTrait;

    public function run(Request $request)
    {
        return $this->getFilteredSuppliers($request)
            ->paginate($request->get('per_page', config('fms.paginationLimit')));
    }

    public function export(Request $request, $returnNumeric = false)
    {
        return $this->getFilteredSuppliers($request, $returnNumeric)
            ->get();
    }

    private function getFilteredSuppliers(Request $request, $returnNumeric = false)
    {
        $user = $request->user();

        return $this->filterSiteByUser($user)
            ->join('tbl_jobs', 'tbl_jobs.site_id', 'sites.id')
            ->leftJoin('tbl_job_invoices', 'tbl_job_invoices.job_id', 'tbl_jobs.id')
            ->join('pivot_jobs_sales', 'pivot_jobs_sales.job_id','tbl_jobs.id')
            ->join('sales_staff', 'sales_staff.id', 'pivot_jobs_sales.sales_id')
            ->select(
                new Expression('
                    any_value(tbl_jobs.completed_on) as completed_on
                '),
                'sales_staff.name as sales_staff',
                'tbl_jobs.job_id as job_id',
                'tbl_jobs.trading_name as trading_name',
                'tbl_jobs.project as project',
                new Expression('CONCAT(ROUND(pivot_jobs_sales.commission), "%") as split'),
                new Expression('
                    if("'.$returnNumeric.' = 1", 
                        tbl_jobs.quote_price, 
                        CONCAT("$",tbl_jobs.quote_price)
                    ) as quoted
                '),
                new Expression('
                    if("'.$returnNumeric.' = 1", 
                        SUM(tbl_job_invoices.net_invoice), 
                        CONCAT("$", SUM(tbl_job_invoices.net_invoice))
                    ) as invoiced
                '),
                new Expression('
                    if("'.$returnNumeric.' = 1", 
                        tbl_jobs.quote_price - tbl_jobs.costed_commission - tbl_jobs.material_total - tbl_jobs.labour_total, 
                        CONCAT("$", tbl_jobs.quote_price - tbl_jobs.costed_commission - tbl_jobs.material_total - tbl_jobs.labour_total)
                    ) as est_margin
                '),
                new Expression('
                    if("'.$returnNumeric.' = 1", 
                        ROUND(((tbl_jobs.quote_price - tbl_jobs.costed_commission - tbl_jobs.material_total - tbl_jobs.labour_total) / tbl_jobs.quote_price) * 100, 2), 
                        CONCAT(ROUND(((tbl_jobs.quote_price - tbl_jobs.costed_commission - tbl_jobs.material_total - tbl_jobs.labour_total) / tbl_jobs.quote_price) * 100, 2),"%")
                    ) as est_gp
                '),
                new Expression('
                    if("'.$returnNumeric.' = 1", 
                        SUM(tbl_job_invoices.net_invoice), 
                        CONCAT("$", SUM(tbl_job_invoices.net_invoice))
                    ) as split_est
                '),
                new Expression('
                    if("'.$returnNumeric.' = 1", ROUND(((tbl_jobs.quote_price - tbl_jobs.costed_commission - tbl_jobs.material_total - tbl_jobs.labour_total) / 100) * pivot_jobs_sales.commission, 2), 
                    CONCAT("$", ROUND(((tbl_jobs.quote_price - tbl_jobs.costed_commission - tbl_jobs.material_total - tbl_jobs.labour_total) / 100) * pivot_jobs_sales.commission, 2))
                    ) as act_margin
                '),
                new Expression('
                    if("'.$returnNumeric.' = 1", ROUND(((tbl_jobs.quote_price - tbl_jobs.costed_commission - tbl_jobs.material_total - tbl_jobs.labour_total) / tbl_jobs.quote_price) * 100, 2), 
                        CONCAT(ROUND(((tbl_jobs.quote_price - tbl_jobs.costed_commission - tbl_jobs.material_total - tbl_jobs.labour_total) / tbl_jobs.quote_price) * 100, 2),"%")
                    ) as act_gp
                '),
                new Expression('
                    if("'.$returnNumeric.' = 1", ROUND(((tbl_jobs.quote_price - tbl_jobs.costed_commission - tbl_jobs.material_total - tbl_jobs.labour_total) / 100) * pivot_jobs_sales.commission, 2), CONCAT(
                        "$", 
                        ROUND(((tbl_jobs.quote_price - tbl_jobs.costed_commission - tbl_jobs.material_total - tbl_jobs.labour_total) / 100) * pivot_jobs_sales.commission, 2)
                    )) as split_actual
                '),
                'tbl_jobs.costed_commission as costed_c',
                new Expression('
                    if("'.$returnNumeric.' = 1", 
                        tbl_jobs.costed_commission, 
                        CONCAT("$", tbl_jobs.costed_commission)
                    ) as costed_c
                '),
                new Expression('
                    if("'.$returnNumeric.' = 1", 
                        ROUND(pivot_jobs_sales.commission * tbl_jobs.costed_commission / 100, 2), 
                        CONCAT("$", ROUND(pivot_jobs_sales.commission * tbl_jobs.costed_commission / 100, 2))
                    ) as split_c_c
                '),
                'sales_staff.id as sales_staff_id'

            )
            ->groupBy('pivot_jobs_sales.id')
            ->filter($this->getFilter());
    }

    private function getFilter()
    {
        // @var AdvanceQueryFilter
        $filter = app(AdvanceQueryFilter::class);

        $filter->setFilterableColumns($this->getFilterableColumns())
            ->setSortableColumns([
                'job_id',
                'trading_name', 
                'store_name',
                'primary_sales_rep'
            ]);

        return $filter;
    }

    private function getFilterableColumns()
    {
        return [
            'where' => [
                'sales_staff' => 'sales_staff.name', 
                'store_name' => 'sites.name',               
            ],
            'having' => [
            ],
        ];
    }
}
