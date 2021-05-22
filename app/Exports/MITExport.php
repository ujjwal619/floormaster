<?php

namespace App\Exports;

use App\FMS\Reports\Job\Queries\MITQuery;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;

class MITExport extends FmExport
{
    private $mitQuery;
    private $request;
    protected $headerCount;

    public function __construct(
        Request $request,
        MITQuery $mitQuery
    ) {
        $this->mitQuery = $mitQuery;    
        $this->request = $request;
        $this->headerCount = 1;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $mits = $this->mitQuery->export($this->request, false);
        $mitsAmount = $this->mitQuery->export($this->request, true);

        $filters = $this->request->get('filters');
        $startDate = $this->request->get('start_date');
        $endDate = $this->request->get('end_date');

        $filterName = $this->filterName($filters, $startDate, $endDate);

        $headings = $this->headings($filterName);

        $data = $this->mapMITData($mits);

        $footer = $this->footers($mitsAmount);

        $mitReport = $headings
                            ->merge($data)
                            ->merge($footer);

        return collect($mitReport);
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
                'Money Held in Trust Report'
            ],
            collect($filterName)->chunk(1)->values()->toArray(),
            [
                'Job', 
                'Client',
                'Store',
                'Receipt Date', 
                'Reference', 
                'Allocated', 
                'Non Allocated', 
            ]
        ]);
    }

    public function mapMITData($mits): array
    {

        $mits = collect($mits)->map(function($taking) {
            return [
                'job' => optional($taking)->job,
                'client' => optional($taking)->client,
                'store_name' => optional($taking)->store_name,
                'receipt_date' => optional($taking)->receipt_date,
                'reference' => optional($taking)->reference,
                'allocated' => optional($taking)->allocated,
                'non_allocated' => optional($taking)->non_allocated,
            ];
        });

        return $mits->toArray();
    }

    private function footers($mitsWithAmount)
    {
        $totalAllocated = $mitsWithAmount->reduce(function ($carry, $mit) {
            return $carry + $mit->allocated;
        });

        $totalNonAllocated = $mitsWithAmount->reduce(function ($carry, $mit) {
            return $carry + $mit->non_allocated;
        });

        $footer = collect([
            [
                '',
                '',
                '',
                '',
                'Total',
                '$'.number_format($totalAllocated, 2),
                '$'.number_format($totalNonAllocated, 2),
            ]
        ]);

        return $footer;
    }
}
