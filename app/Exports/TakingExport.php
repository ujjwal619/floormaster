<?php

namespace App\Exports;

use App\FMS\Reports\Job\Queries\TakingQuery;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;

class TakingExport implements FromCollection
{
    private $takingQuery;
    private $request;
    private $takingData;

    public function __construct(
        Request $request,
        TakingQuery $takingQuery
    ) {
        $this->takingQuery = $takingQuery;    
        $this->request = $request;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $takings = $this->takingQuery->export($this->request, false);
        $takingsAmount = $this->takingQuery->export($this->request, true);

        $filters = $this->request->get('filters');
        $startDate = $this->request->get('start_date');
        $endDate = $this->request->get('end_date');

        $filterName = $this->filterName($filters, $startDate, $endDate);

        $headings = $this->headings($filterName);

        $data = $this->mapTakingData($takings);

        $footer = $this->footers($takingsAmount);

        $takingReport = $headings
                            ->merge($data)
                            ->merge($footer);

        return collect($takingReport);
    }

    private function filterName($filters, $startDate, $endDate)
    {
        $filterName = 'Date From ' . date('j F Y', strtotime($startDate)) . ' to ' . date('j F Y', strtotime($endDate)) . ' ';
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
                'Taking Report'
            ],
            [
                $filterName
            ],
            [
                'Receipt Date', 
                'Inv. no.',
                'Store',
                'Client', 
                'Reference', 
                'Amount', 
            ]
        ]);
    }

    public function mapTakingData($takings): array
    {

        $takings = collect($takings)->map(function($taking) {
            return [
                'receipt_date' => optional($taking)->receipt_date,
                'invoice_no' => optional($taking)->invoice_no,
                'store_name' => optional($taking)->store_name,
                'client' => optional($taking)->client,
                'reference' => optional($taking)->reference,
                'amount' => optional($taking)->amount,
            ];
        });

        $this->takingData = $takings;
        
        return $takings->toArray();
    }

    private function footers($takingsWithAmount)
    {
        $totalAmount = $takingsWithAmount->reduce(function ($carry, $taking) {
            return $carry + $taking->amount;
        });

        $footer = collect([
            [
                '',
                '',
                '',
                '',
                'Total',
                '$'.number_format($totalAmount, 2),
            ]
        ]);

        return $footer;
    }
}
