<?php

namespace App\FMS\Reports\Job\Actions;

use App\Exports\TakingExport;
use App\FMS\Reports\Job\Queries\TakingQuery;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelExcel;

class ExportTaking extends AdminController
{
    public function __invoke(
        Request $request,
        TakingQuery $takingQuery
    ) {
        try {
            return Excel::download(new TakingExport($request, $takingQuery), 'takings_report.xlsx');
            return Excel::download(new TakingExport($request, $takingQuery), 'takings_report.pdf', ExcelExcel::MPDF);
        } catch (\Exception $exception) {
            dd($exception);
        }
    }
}
