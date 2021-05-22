<?php

namespace App\FMS\Reports\Job\Queries;

use App\FMS\Filters\AdvanceQueryFilter;
use App\FMS\Site\Traits\FilterSiteByUserTrait;
use Illuminate\Database\Query\Expression;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkInProgressQuery
{
    use FilterSiteByUserTrait;

    public function run(Request $request)
    {
        return $this->getPaginatedWIP($request)
            ->paginate($request->get('per_page', config('fms.paginationLimit')));
    }

    public function export(Request $request, $returnNumeric = false)
    {
        return $this->getPaginatedWIP($request, $returnNumeric)
            ->get();
    }

    public function all(Request $request)
    {
        $site = $request->get('site', null);
        $shop = $request->get('shop', null);

        $wips = $this->baseQuery($request);
        
        if ($site) {
            $wips->where('tbl_jobs.site_id', '=', $site);
        }

        if ($shop) {
            $wips->where('tbl_jobs.shop_id', '=', $shop);
        }

        return $wips->get();
    }

    private function baseQuery(Request $request, $returnNumeric = false)
    {
        $user = $request->user();

        DB::statement("SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");

        return $this->filterSiteByUser($user)
            ->join('tbl_jobs', 'tbl_jobs.site_id', 'sites.id')
            ->leftJoin('shops', 'shops.id', 'tbl_jobs.shop_id')
            ->join('pivot_jobs_sales', 'pivot_jobs_sales.job_id','tbl_jobs.id')
            ->join('sales_staff', 'sales_staff.id', 'pivot_jobs_sales.sales_id')
            ->leftJoin('tbl_job_invoices', 'tbl_job_invoices.job_id', 'tbl_jobs.id')
            ->leftJoin('tbl_job_receipts', 'tbl_job_receipts.invoice_id', 'tbl_job_invoices.id')
            ->leftJoin('invoice_expenses', 'invoice_expenses.invoice_id', 'tbl_job_invoices.id')
            ->select(
                'tbl_jobs.job_id as job_id',
                'tbl_jobs.id as id',
                'sites.id as site_id',
                'sites.name as store_name',
                'shops.id as shop_id',
                'shops.name as shop_name',
                new Expression('"" as order_status'),
                'tbl_jobs.initiation_date as initiation_date',
                'tbl_jobs.completed_on as completion_date',
                'tbl_jobs.completed_on as measured_date',
                'tbl_jobs.completed_percent as completed_percent',
                'sales_staff.name as primary_sales_rep',
                'tbl_jobs.trading_name as trading_name',
                'tbl_jobs.project as project',
                'tbl_jobs.phone as home_phone',
                'tbl_jobs.work_phone as work_phone',
                new Expression(
                    "if('".$returnNumeric." = TRUE', tbl_jobs.gst_inclusive_quote, CONCAT('$', tbl_jobs.gst_inclusive_quote)) as quoted"
                ),
                new Expression(
                    "if('".$returnNumeric." = TRUE', tbl_jobs.invoiced, CONCAT('$', tbl_jobs.invoiced)) as invoiced"
                ),
                new Expression(
                    "if('".$returnNumeric." = TRUE', tbl_jobs.balance, CONCAT('$', tbl_jobs.balance)) as balance"
                ),
                'tbl_jobs.completed_on as notes',
                'pivot_jobs_sales.priority as priority'
            )
            ->where('pivot_jobs_sales.priority','primary')
            ->distinct('tbl_jobs.id');
    }
                
    private function getPaginatedWIP(Request $request, $returnNumeric = false)
    {
        return $this->baseQuery($request, $returnNumeric)
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
                'primary_sales_rep' => 'sales_staff.name', 
                'store_name' => 'sites.name',               
                'shop_name' => 'shops.name',               
            ],
            'having' => [
            ],
        ];
    }
}
