<?php

namespace App\Exports;

use App\FMS\Reports\Job\Queries\JobCostsQuery;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class JobCostsExport extends FmExport
{
    private $jobCostsQuery;
    private $request;
    private $jobCostsData;
    protected $headerCount;

    public function __construct(
        Request $request,
        JobCostsQuery $jobCostsQuery
    ) {
        $this->jobCostsQuery = $jobCostsQuery;    
        $this->request = $request;
        $this->headerCount = 1;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $jobCosts = $this->jobCostsQuery->export($this->request, false);
        $jobCostsAmount = $this->jobCostsQuery->export($this->request, true);

        $filters = $this->request->get('filters');
        $startDate = $this->request->get('start_date');
        $endDate = $this->request->get('end_date');

        $filterName = $this->filterName($filters, $startDate, $endDate);

        $headings = $this->headings($filterName);

        $data = $this->mapjobCostsData($jobCosts);

        $footer = $this->footers($jobCostsAmount);

        $jobCostReport = $headings
                            ->merge($data)
                            ->merge($footer);

        return collect($jobCostReport);
    }

    private function filterName($filters, $startDate, $endDate)
    {
        $filterName = ['Date From ' . date('j F Y', strtotime($startDate)) . ' to ' . date('j F Y', strtotime($endDate)) . ' '];
        $this->headerCount++;
        
        $storeName = array_get($filters, 'store_name', []);
        if ($storeName && array_get($storeName, 'equals')) {
            array_push($filterName, 'Store Name is ' . array_get($storeName, 'equals') . ' ');
            $this->headerCount++;
        }

        return $filterName;
    }

    private function headings($filterName)
    {
        return collect([
            [
                'Job Costs Report'
            ],
            collect($filterName)->chunk(1)->values()->toArray(),
            [
                'Job', 
                'Store',
                'Shop',
                'Client', 
                'Project', 
                'Primary Rep', 
                'Invoiced', 
                'Last Invoiced', 
                'Last Invoiced Date', 
                'Creditors', 
                'Contractors', 
                'Total Cost', 
                'Margin To Date', 
            ]
        ]);
    }

    public function mapjobCostsData($jobCosts): array
    {
        $jobCosts = collect($jobCosts)->unique('id')->map(function($jobCost) {
            return [
                'job_id' => optional($jobCost)->job_id,
                'store_name' => optional($jobCost)->store_name,
                'shop_name' => optional($jobCost)->shop_name,
                'trading_name' => optional($jobCost)->trading_name,
                'project' => optional($jobCost)->project,
                'primary_sales_rep' => optional($jobCost)->primary_sales_rep,
                'invoiced' => optional($jobCost)->invoiced,
                'last_invoiced' => optional($jobCost)->last_invoiced,
                'last_invoiced_date' => optional($jobCost)->last_invoiced_date,
                'creditors' => optional($jobCost)->creditors,
                'contractors' => optional($jobCost)->contractors,
                'total_cost' => optional($jobCost)->total_cost,
                'margin_to_date' => optional($jobCost)->margin_to_date,
            ];
        });

        $this->jobCostsData = $jobCosts;
        
        return $jobCosts->toArray();
    }

    private function footers($jobCostsWithAmount)
    {
        $totalCreditors = $jobCostsWithAmount->reduce(function ($carry, $jobCost) {
            return $carry + $jobCost->creditors;
        });

        $totalContractros = $jobCostsWithAmount->reduce(function ($carry, $jobCost) {
            return $carry + $jobCost->contractors;
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
                'Total',
                '$'.number_format($totalCreditors, 2),
                '$'.number_format($totalContractros, 2),
                '',
                '',
            ]
        ]);

        return $footer;
    }
}
