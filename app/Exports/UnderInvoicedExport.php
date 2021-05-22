<?php

namespace App\Exports;

use App\FMS\Reports\Job\Queries\UnderInvoicedQuery;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;

class UnderInvoicedExport implements FromCollection
{
    private $underInvoicedQuery;
    private $request;
    private $underInvoicedData;

    public function __construct(
        Request $request,
        UnderInvoicedQuery $underInvoicedQuery
    ) {
        $this->underInvoicedQuery = $underInvoicedQuery;    
        $this->request = $request;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $underInvoiced = $this->underInvoicedQuery->export($this->request, false);
        $underInvoicedAmount = $this->underInvoicedQuery->export($this->request, true);

        $filters = $this->request->get('filters');
        $startDate = $this->request->get('start_date');
        $endDate = $this->request->get('end_date');

        $filterName = $this->filterName($filters, $startDate, $endDate);

        $headings = $this->headings($filterName);

        $data = $this->mapUnderInvoicedData($underInvoiced);

        $footer = $this->footers($underInvoicedAmount);

        $jobCostReport = $headings
                            ->merge($data)
                            ->merge($footer);

        return collect($jobCostReport);
    }

    private function filterName($filters, $startDate, $endDate)
    {
        $filterName = 'Date From ' . date('j F Y', strtotime($startDate)) . ' to ' . date('j F Y', strtotime($endDate)) . ' ';
        $storeName = array_get($filters, 'store_name', []);

        if ($storeName && array_get($storeName, 'equals')) {
            $filterName = 'Store Name is ' . array_get($storeName, 'equals') . ' ';
        }

        if ($storeName && array_get($storeName, 'equals')) {
            $filterName = 'Store Name is ' . array_get($storeName, 'equals') . ' ';
        }

        return $filterName;
    }

    private function headings($filterName)
    {
        return collect([
            [
                'Under Invoiced Report'
            ],
            [
                $filterName
            ],
            [
                'Job', 
                'Store',
                'Shop',
                'Client', 
                'Completed Date', 
                'Quoted', 
                'Invoiced', 
                'Difference', 
            ]
        ]);
    }

    public function mapUnderInvoicedData($underInvoiced): array
    {
        $underInvoiced = collect($underInvoiced)->unique('id')->map(function($jobCost) {
            return [
                'job_id' => optional($jobCost)->job_id,
                'store_name' => optional($jobCost)->store_name,
                'shop_name' => optional($jobCost)->shop_name,
                'trading_name' => optional($jobCost)->trading_name,
                'completion_on' => optional($jobCost)->completion_date,
                'quoted' => optional($jobCost)->quoted,
                'invoiced' => optional($jobCost)->invoiced,
                'difference' => optional($jobCost)->difference,
            ];
        });

        $this->underInvoicedData = $underInvoiced;
        
        return $underInvoiced->toArray();
    }

    private function footers($underInvoicedWithAmount)
    {
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
            ]
        ]);

        return $footer;
    }
}
