<?php

namespace App\FMS\Reports\Job\Queries;

use App\FMS\Filters\AdvanceQueryFilter;
use App\FMS\Site\Traits\FilterSiteByUserTrait;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobCostsQuery
{
    use FilterSiteByUserTrait;

    public function run(Request $request)
    {
        return $this->getPaginatedJobCosts($request, true)
            ->paginate($request->get('per_page', config('fms.paginationLimit')));
    }

    public function export(Request $request, $returnNumeric = false)
    {
        return collect($this->getPaginatedJobCosts($request, $returnNumeric)
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
            ->join('pivot_jobs_sales', 'pivot_jobs_sales.job_id','tbl_jobs.id')
            ->join('sales_staff', 'sales_staff.id', 'pivot_jobs_sales.sales_id')
            ->leftJoin(DB::raw('(SELECT sum(totalInvoice.net_invoice) netInvoice, totalInvoice.job_id
                   FROM tbl_job_invoices as totalInvoice
                   group by totalInvoice.job_id) as totalInvoice'), function (JoinClause $joinClause) {
                $joinClause->on('tbl_jobs.id', '=', 'totalInvoice.job_id');
            })
            // ->leftJoin('tbl_job_invoices as lastInvoiced', function (JoinClause $joinClause) {
            //     return $joinClause->on('lastInvoiced.job_id', '=', 'tbl_jobs.id');
            // })
            ->leftJoin(DB::raw('(SELECT sum(contractors.amount) netPayment, contractors.job_id
                   FROM tbl_contractor_payments_due as contractors
                   group by contractors.job_id) as contractors'), function (JoinClause $joinClause) {
                $joinClause->on('tbl_jobs.id', '=', 'contractors.job_id');
            })
            ->leftJoin(DB::raw('(SELECT sum(creditors.expected_amount) netPayment, creditors.job_id
                   FROM supplier_payables as creditors
                   group by creditors.job_id) as creditors'), function (JoinClause $joinClause) {
                $joinClause->on('tbl_jobs.id', '=', 'creditors.job_id');
            })
            // ->leftJoin(DB::raw('(SELECT sum(paid.net_payment) netPayment, paid.job
            //        FROM remittance_items as paid
            //        where paid.is_paid = true
            //        group by paid.job) as paid'), function (JoinClause $joinClause) {
            //     $joinClause->on('tbl_jobs.id', '=', 'paid.job');
            // })
            ->leftJoin(DB::raw('(select amount, date, tbl_job_invoices.job_id from tbl_job_invoices, tbl_jobs
                        WHERE
                        tbl_job_invoices.id = (
                            SELECT MAX(tbl_job_invoices.id)
                            FROM tbl_job_invoices
                            WHERE job_id = tbl_jobs.id
                        )
                    ) as lastInvoiced'), function (JoinClause $joinClause) {
                $joinClause->on('tbl_jobs.id', '=', 'lastInvoiced.job_id');
            })
            ->select(
                'tbl_jobs.job_id as job_id',
                'tbl_jobs.id as id',
                'sites.id as site_id',
                'sites.name as store_name',
                'shops.id as shop_id',
                'shops.name as shop_name',
                'sales_staff.name as primary_sales_rep',
                'tbl_jobs.trading_name as trading_name',
                'tbl_jobs.project as project',
                'pivot_jobs_sales.priority as priority',
                new Expression(
                    "if('".$returnNumeric." = TRUE', lastInvoiced.amount, CONCAT('$', lastInvoiced.amount)) as last_invoiced"
                ),
                'lastInvoiced.date as last_invoiced_date',
                new Expression(
                    "if('".$returnNumeric." = TRUE', totalInvoice.netInvoice, CONCAT('$', totalInvoice.netInvoice)) as invoiced"
                ),
                new Expression(
                    "if('".$returnNumeric." = TRUE', contractors.netPayment, CONCAT('$', contractors.netPayment)) as contractors"
                ),
                new Expression(
                    "if('".$returnNumeric." = TRUE', creditors.netPayment, CONCAT('$', creditors.netPayment)) as creditors"
                ),
                new Expression(
                    "if('".$returnNumeric." = TRUE', contractors.netPayment + creditors.netPayment, CONCAT('$', contractors.netPayment + creditors.netPayment)) as total_cost"
                ),
                new Expression(
                    "if('".$returnNumeric." = TRUE', totalInvoice.netInvoice, CONCAT('$', totalInvoice.netInvoice)) as margin_to_date"
                )
            )
            ->where('pivot_jobs_sales.priority','primary')
            ->whereBetween('tbl_jobs.initiation_date', [$startDate, $endDate])
            ;
    }
                
    private function getPaginatedJobCosts(Request $request, $returnNumeric = false)
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
