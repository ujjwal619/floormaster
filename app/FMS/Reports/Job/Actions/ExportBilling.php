<?php

namespace App\FMS\Reports\Job\Actions;

use App\FMS\Reports\Job\Queries\BillingQuery;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ExportBilling extends AdminController
{
    public function __invoke(
        Request $request,
        BillingQuery $billingQuery
    ) {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $filters = $request->get('filters');

        $billings = $billingQuery->export($request, false);
        $billingsAmount = $billingQuery->export($request, true);

        $totalNetInvoice = $billingsAmount->reduce(function ($carry, $billing) {
            return $carry + $billing->net_invoice;
        });

        $totalGstAmount = $billingsAmount->reduce(function ($carry, $billing) {
            return $carry + $billing->gst_amount;
        });

        $totalGrossAmount = $billingsAmount->reduce(function ($carry, $billing) {
            return $carry + $billing->gross_amount;
        });
        
        $totalBalanceDue = $billingsAmount->reduce(function ($carry, $billing) {
            return $carry + $billing->balance_due;
        });


        $filterName = 'Date From ' . date('j F Y', strtotime($startDate)) . ' to ' . date('j F Y', strtotime($endDate)) . ' ';
        $storeName = array_get($filters, 'store_name', []);
        $salesStaff = array_get($filters, 'sales_staff', []);

        if ($storeName && array_get($storeName, 'equals')) {
            $filterName = $filterName . 'Store Name is ' . array_get($storeName, 'equals') . ' ';
        }
        if ($salesStaff && array_get($salesStaff, 'equals')) {
            $filterName = $filterName . 'Sales Staff is ' . array_get($salesStaff, 'equals') . ' ';
        }

        $headings = collect([
            [
                'Billing Report'
            ],
            [
                $filterName
            ],
            [
                'Invoice No.',
                'Store',
                'Invoice Date',
                'Invoice Type',
                'Client',
                'Project',
                'Net',
                'Gst',
                'Gross',
                'Balance Due',
                'Sales Rep.',
            ]
        ]);

        $data = $headings->merge($billings);

        $footer = collect([
            [
                '',
                '',
                '',
                '',
                '',
                '',
                '$'.number_format($totalNetInvoice, 2),
                '$'.number_format($totalGstAmount, 2),
                '$'.number_format($totalGrossAmount, 2),
                '$'.number_format($totalBalanceDue, 2),
                ''
            ],
            [
                '',
                '',
                '',
                '',
                '',
                
            ]
        ]);

        return  $data->merge($footer)->downloadExcel(
            'billing_report.xlsx',
            null,
            false
        );
    }
}
