<?php

namespace App\Exports;

use App\FMS\Reports\Job\Queries\WorkInProgressQuery;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;

class WIPExport implements FromCollection
{
    private $workInProgressQuery;
    private $request;
    private $wipData;

    public function __construct(
        Request $request,
        WorkInProgressQuery $workInProgressQuery
    ) {
        $this->workInProgressQuery = $workInProgressQuery;    
        $this->request = $request;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $jobs = $this->workInProgressQuery->export($this->request);
        $jobsAmount = $this->workInProgressQuery->export($this->request, true);


        $filters = $this->request->get('filters');

        $filterName = $this->filterName($filters);

        $headings = $this->headings($filterName);

        $data = $this->mapWipData($jobs);

        $footer = $this->footers($jobsAmount);


        $commissionReport = $headings
                            ->merge($data)
                            ->merge($footer);

        return collect($commissionReport);
    }

    private function filterName($filters)
    {
        $filterName = 'All Report';
        $storeName = array_get($filters, 'store_name', []);

        if ($storeName && array_get($storeName, 'equals')) {
            $filterName = 'Store Name is ' . array_get($storeName, 'equals') . ' ';
        }

        return $filterName;
    }

    private function headings($filterName)
    {
        return collect([
            [
                'Work In Progress Report'
            ],
            [
                $filterName
            ],
            [
                'Job', 
                'Store', 
                'Order_status', 
                'Initiated', 
                'Completion', 
                'Measured', 
                'Primary Rep', 
                'Client', 
                'Project', 
                'Home Ph',
                'Work Ph',
                'Quoted', 
                'Invoiced', 
                'Balance',
                'Notes'
            ]
        ]);
    }

    public function mapWipData($wips): array
    {
        $wips = collect($wips)->map(function($wip) {
            return [
                'job_id' => optional($wip)->job_id,
                'store_name' => optional($wip)->store_name,
                'order_status' => optional($wip)->order_status,
                'initiation_date' => optional($wip)->initiation_date,
                'complition_date' => optional($wip)->completion_date,
                'measured_date' => optional($wip)->measured_date,
                'primary_sales_rep' => optional($wip)->primary_sales_rep,
                'trading_name' => optional($wip)->trading_name,
                'project' => optional($wip)->project,
                'home_phone' => optional($wip)->home_phone,
                'work_phone' => optional($wip)->work_phone,
                'quoted' => optional($wip)->quoted,
                'invoiced' => optional($wip)->invoiced,
                'balance' => optional($wip)->balance,
            ];
        });

        $this->wipData = $wips;
        
        return $wips->toArray();
    }

    private function footers($wipsWithAmount)
    {
        $totalQuoted = $wipsWithAmount->reduce(function ($carry, $job) {
            return $carry + $job->quoted;
        });

        $totalInvoiced = $wipsWithAmount->reduce(function ($carry, $job) {
            return $carry + $job->invoiced;
        });
        
        $totalBalance = $wipsWithAmount->reduce(function ($carry, $job) {
            return $carry + $job->balance;
        });

        $footer = collect([
            [
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                'Total',
                '$'.number_format($totalQuoted, 2),
                '$'.number_format($totalInvoiced, 2),
                '$'.number_format($totalBalance, 2),
                ''
            ]
        ]);
    }
}
