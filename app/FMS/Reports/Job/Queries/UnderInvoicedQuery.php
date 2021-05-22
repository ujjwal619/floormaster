<?php

namespace App\FMS\Reports\Job\Queries;

use App\FMS\Filters\AdvanceQueryFilter;
use App\FMS\Site\Traits\FilterSiteByUserTrait;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnderInvoicedQuery
{
    use FilterSiteByUserTrait;

    public function run(Request $request)
    {
        return $this->getPaginatedUnderInvoiced($request, true)
            ->paginate($request->get('per_page', config('fms.paginationLimit')));
    }

    public function export(Request $request, $returnNumeric = false)
    {
        return collect($this->getPaginatedUnderInvoiced($request, $returnNumeric)
        ->get())->unique('id');
    }

    public function all(Request $request)
    {
        $site = $request->get('site', null);
        $shop = $request->get('shop', null);

        $jobCosts = $this->baseQuery($request);
        
        if ($site) {
            $jobCosts->where('tbl_jobs.site_id', '=', $site);
        }

        if ($shop) {
            $jobCosts->where('tbl_jobs.shop_id', '=', $shop);
        }

        return $jobCosts->get();
    }

    private function baseQuery(Request $request, $returnNumeric = false)
    {
        $user = $request->user();
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        // dd(1, DB::statement("select id from tbl_job_invoices where tbl_job_invoices.created_at = (select max(tbl_job_invoices.created_at) from tbl_job_invoices)"));

        return $this->filterSiteByUser($user)
            ->join('tbl_jobs', 'tbl_jobs.site_id', 'sites.id')
            ->leftJoin('shops', 'shops.id', 'tbl_jobs.shop_id')
            ->leftJoin(DB::raw('(SELECT sum(totalInvoice.net_invoice) netInvoice, totalInvoice.job_id
                   FROM tbl_job_invoices as totalInvoice
                   group by totalInvoice.job_id) as totalInvoice'), function (JoinClause $joinClause) {
                $joinClause->on('tbl_jobs.id', '=', 'totalInvoice.job_id');
            })
            ->leftJoin(DB::raw('(SELECT sum(totalBilled.amount) amount, totalBilled.job_id
                   FROM tbl_job_invoices as totalBilled
                   group by totalBilled.job_id) as totalBilled'), function (JoinClause $joinClause) {
                $joinClause->on('tbl_jobs.id', '=', 'totalBilled.job_id');
            })
            ->select(
                'tbl_jobs.job_id as job_id',
                'tbl_jobs.id as id',
                'sites.id as site_id',
                'sites.name as store_name',
                'shops.id as shop_id',
                'shops.name as shop_name',
                'tbl_jobs.trading_name as trading_name',
                'tbl_jobs.completed_on as completion_date',
                new Expression(
                    "if('".$returnNumeric." = TRUE', totalInvoice.netInvoice, CONCAT('$', totalInvoice.netInvoice)) as quoted"
                ),

                new Expression(
                    "if('".$returnNumeric." = TRUE', totalBilled.amount, CONCAT('$', totalBilled.amount)) as invoiced"
                ),
                new Expression(
                    "if('".$returnNumeric." = TRUE', totalInvoice.netInvoice - totalBilled.amount, CONCAT('$', totalInvoice.netInvoice - totalBilled.amount)) as difference"
                )
            )
            ->whereBetween('tbl_jobs.completed_on', [$startDate, $endDate])
            ;
    }
                
    private function getPaginatedUnderInvoiced(Request $request, $returnNumeric = false)
    {
        return $this->baseQuery($request, $returnNumeric)
        ->filter($this->getFilter())
        ;
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
        ]);
                    
        return $filter;
    }

    private function getFilterableColumns()
    {
        return [
            'where' => [
                'store_name' => 'sites.name',               
                'shop_name' => 'shops.name',               
            ],
            'having' => [
            ],
        ];
    }
}
