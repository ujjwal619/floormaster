<?php

namespace App\Exports;

use App\FMS\Reports\Job\Queries\CommissionQuery;
use Illuminate\Http\Request;
use App\FMS\SalesStaff\Manager as SalesStaffManager;
use App\FMS\User\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CommissionsExport extends FmExport
{
    use Exportable, RegistersEventListeners;

    private $request;
    private $commissionQuery;
    private $salesStaffManager;
    private $commissionData;
    protected $headerCount;

    public function __construct(
        Request $request, 
        CommissionQuery $commissionQuery,
        SalesStaffManager $salesStaffManager
    ) {
        $this->request = $request;
        $this->commissionQuery = $commissionQuery;
        $this->salesStaffManager = $salesStaffManager;
        $this->headerCount = 1;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $commissions = $this->commissionQuery->export($this->request);
        $commissionsWithAmount = $this->commissionQuery->export($this->request, true);

        $filters = $this->request->get('filters');

        $filterName = $this->filterName($filters);

        $headings = $this->headings($filterName);

        $data = $this->mapCommissionData($commissions);

        $footer = $this->footers($commissionsWithAmount);


        $commissionReport = $headings
                            ->merge($data)
                            ->merge($footer);

        return collect($commissionReport);
    }

    public static function beforeSheet(BeforeSheet $event)
    {
        // $mpdf = app(Mpdf::class); 
        // $mpdf->setOrientation('landscape');
        // // $sheet = Sheet
    }

    public function mapCommissionData($commissions): array
    {
        $commissions = collect($commissions)->map(function($commission) {
            return [
                'completed_on' => optional($commission)->completed_on,
                'sales_staff' => optional($commission)->sales_staff,
                'job_id' => optional($commission)->job_id,
                'trading_name' => optional($commission)->trading_name,
                'project' => optional($commission)->project,
                'split' => optional($commission)->split,
                'quoted' => optional($commission)->quoted,
                'invoiced' => optional($commission)->invoiced,
                'est_margin' => optional($commission)->est_margin,
                'est_gp' => optional($commission)->est_gp,
                'split_est' => optional($commission)->split_est,
                'act_margin' => optional($commission)->act_margin,
                'act_gp' => optional($commission)->act_gp,
                'split_actual' => optional($commission)->split_actual,
                'costed_c' => optional($commission)->costed_c,
                'split_c_c' => optional($commission)->split_c_c,
            ];
        });

        $this->commissionData = $commissions;
        
        return $commissions->toArray();
    }

    private function footers($commissionsWithAmount)
    {
        $salesStaffId = optional($commissionsWithAmount->first())->sales_staff_id;
        
        $salesStaff = optional($this->salesStaffManager->findWhere(['id' => $salesStaffId]));

        $totalQuoted = $commissionsWithAmount->reduce(function ($carry, $job) {
            return $carry + $job->quoted;
        });

        $totalInvoiced = $commissionsWithAmount->reduce(function ($carry, $job) {
            return $carry + $job->invoiced;
        });

        $totalEstMargin = $commissionsWithAmount->reduce(function ($carry, $job) {
            return $carry + $job->est_margin;
        });
        
        $totalEstGp = '-';

        $totalSplitEst = $commissionsWithAmount->reduce(function ($carry, $job) {
            return $carry + $job->split_est;
        });

        $totalActMargin = $commissionsWithAmount->reduce(function ($carry, $job) {
            return $carry + $job->act_margin;
        });

        $totalSplitEst = $commissionsWithAmount->reduce(function ($carry, $job) {
            return $carry + $job->split_est;
        });

        $totalActGp = '-';

        $totalSplitActual = $commissionsWithAmount->reduce(function ($carry, $job) {
            return $carry + $job->split_actual;
        });

        $totalCostedC = $commissionsWithAmount->reduce(function ($carry, $job) {
            return $carry + $job->costed_c;
        });

        $totalCostedCC = $commissionsWithAmount->reduce(function ($carry, $job) {
            return $carry + $job->costed_c_c;
        });

        $firstTierPayRate = $salesStaff->first_tier ? $salesStaff->first_tier->pay_rate : null;
        $firstTierDollarValue = $salesStaff->first_tier ? $salesStaff->first_tier->dollar_value : null;
        $secondTierPayRate = $salesStaff->second_tier ? $salesStaff->second_tier->pay_rate : null;
        $secondTierDollarValue = $salesStaff->second_tier ? $salesStaff->second_tier->dollar_value : null;
        $thirdTierPayRate = $salesStaff->third_tier ? $salesStaff->third_tier->pay_rate : null;
        $thirdTierDollarValue = $salesStaff->third_tier ? $salesStaff->third_tier->dollar_value : null;

        $firstTierCommissionLimit = $secondTierDollarValue - $firstTierDollarValue; 
        $secondTierCommissionLimit = $thirdTierDollarValue - $secondTierDollarValue < 0 ? 0 : $thirdTierDollarValue - $secondTierDollarValue; 

        $firstTierCommissionGivenOn = $totalEstMargin > $firstTierCommissionLimit ? $firstTierCommissionLimit : $totalEstMargin;
        $remainingSplit = $totalEstMargin - $firstTierCommissionGivenOn;
        $secondTierCommissionGivenOn = 0;
        if ($remainingSplit > 0) {
            $secondTierCommissionGivenOn = $remainingSplit < $secondTierCommissionLimit ? $remainingSplit : $secondTierCommissionLimit;
        } 
        $remainingSplit = $remainingSplit - $secondTierCommissionGivenOn;
        
        $thirdTierCommissionGivenOn = 0;
        if ($remainingSplit > 0) {
            $thirdTierCommissionGivenOn = $remainingSplit;
        }

        $firstTierCommission = ($firstTierCommissionGivenOn - $firstTierDollarValue)  * $firstTierPayRate / 100;
        $secondTierCommission = $secondTierCommissionGivenOn * $secondTierPayRate / 100;
        $thirdTierCommission = $thirdTierCommissionGivenOn * $thirdTierPayRate / 100;

        return  collect([
            [
                '',
                '',
                '',
                '',
                '',
                '',
                '$'.number_format($totalQuoted, 2),
                '$'.number_format($totalInvoiced, 2),
                '$'.number_format($totalEstMargin, 2),
                $totalEstGp,
                '$'.number_format($totalSplitEst, 2),
                '$'.number_format($totalActMargin, 2),
                $totalActGp,
                '$'.number_format($totalSplitActual, 2),
                '$'.number_format($totalCostedC, 2),
                '$'.number_format($totalCostedCC, 2),
            ],
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
                '',
                '',
                '',
                $firstTierPayRate . '% Commission on GP$ over $' . number_format($firstTierDollarValue, 2) . '( $'. number_format($firstTierCommissionGivenOn, 2) . ' )' ,
                '',
                '$' . number_format($firstTierCommission, 2),
            ],
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
                '',
                '',
                '',
                $secondTierPayRate . '% Commission on GP$ over $' . number_format($secondTierDollarValue, 2) . '( $'. number_format($secondTierCommissionGivenOn, 2) . ' )' ,
                '',
                '$' . number_format($secondTierCommission, 2),
            ],

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
                '',
                '',
                '',
                $thirdTierPayRate . '% Commission on GP$ over $' . number_format($thirdTierDollarValue, 2) . '( $'. number_format($thirdTierCommissionGivenOn, 2) . ' )' ,
                '',
                '$' . number_format($thirdTierCommission, 2),
            ],
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
                '',
                '',
                '',
                'Total',
                '',
                '$' . number_format($firstTierCommission + $secondTierCommission + $thirdTierCommission, 2),
            ],
        ]);
    }

    private function filterName($filters)
    {
        $filterName = ['All Report'];
        $this->headerCount++;
        $storeName = array_get($filters, 'store_name', []);
        $salesStaff = array_get($filters, 'sales_staff', []);

        if ($storeName && array_get($storeName, 'equals')) {
            $filterName = ['Store Name is ' . array_get($storeName, 'equals') . ' '];
        }
        if ($salesStaff && array_get($salesStaff, 'equals')) {
            array_push($filterName, 'Sales Staff is ' . array_get($salesStaff, 'equals') . ' ');
            $this->headerCount++;
        }

        return $filterName;
    }

    private function headings($filterName)
    {
        return collect([
            [
                'Sales Commission Report'
            ],
            collect($filterName)->chunk(1)->values()->toArray(),
            [
                'Completed',
                'Sales Rep', 
                'Job', 
                'Client', 
                'Project', 
                'Split', 
                'Quoted', 
                'Invoiced',
                'Est Margin',
                'Est GP', 
                'Split Est', 
                'Act Margin',
                'Act GP',
                'Split Actual',
                'Costed C.',
                'Split C. C.'
            ]
        ]);
    }

    public function styles(Worksheet $sheet)
    {

        $columnHeaderRow = $this->headerCount + 1;
        for($i = 1; $i <= $this->headerCount; $i++) {
            $sheet->mergeCells(sprintf('A%s:F%s', $i, $i));

            $sheet->getStyle($i)->getFont()->setBold(true);
        }

        $dataCount = $this->commissionData->count() + 1;
        $totalRow = $dataCount + 7;
        $tier1Total = $dataCount + 4;
        $tier2Total = $dataCount + 5;
        $tier3Total = $dataCount + 6;

        return [
            $columnHeaderRow    => ['font' => ['bold' => true]],
            // 'C'  => ['alignment' => ['horizontal' => 'left']],
            // 'F'  => ['alignment' => ['horizontal' => 'right']],
            // 'G'  => ['alignment' => ['horizontal' => 'right']],
            // 'H'  => ['alignment' => ['horizontal' => 'right']],
            // 'I'  => ['alignment' => ['horizontal' => 'right']],
            // 'J'  => ['alignment' => ['horizontal' => 'right']],
            // 'K'  => ['alignment' => ['horizontal' => 'right']],
            // 'L'  => ['alignment' => ['horizontal' => 'right']],
            // 'M'  => ['alignment' => ['horizontal' => 'right']],
            // 'N'  => ['alignment' => ['horizontal' => 'right']],
            // 'O'  => ['alignment' => ['horizontal' => 'right']],
            // 'P'  => ['alignment' => ['horizontal' => 'right']],
            // $totalRow    => ['font' => ['bold' => true], 'alignment' => ['horizontal' => 'right']],
            // 'P'. $tier1Total  => ['font' => ['bold' => true], 'alignment' => ['horizontal' => 'right']],
            // 'P'. $tier2Total  => ['font' => ['bold' => true], 'alignment' => ['horizontal' => 'right']],
            // 'P'. $tier3Total  => ['font' => ['bold' => true], 'alignment' => ['horizontal' => 'right']],
        ];
    }
}
