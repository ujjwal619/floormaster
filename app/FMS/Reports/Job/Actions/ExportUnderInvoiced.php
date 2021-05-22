<?php

namespace App\FMS\Reports\Job\Actions;

use App\Exports\UnderInvoicedExport;
use App\FMS\Reports\Job\Queries\UnderInvoicedQuery;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelExcel;

class ExportUnderInvoiced extends AdminController
{
    public function __invoke(
        Request $request,
        UnderInvoicedQuery $underInvoicedQuery
    ) {
        try {
            return Excel::download(new UnderInvoicedExport($request, $underInvoicedQuery), 'under_invoiced_report.xlsx');
            return Excel::download(new UnderInvoicedExport($request, $underInvoicedQuery), 'under_invoiced_report.pdf', ExcelExcel::MPDF);
        } catch (\Exception $exception) {
            dd($exception);
        }
    }
}
