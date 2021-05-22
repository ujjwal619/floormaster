<?php

namespace App\FMS\Reports\Job\Actions;

use App\Exports\WIPExport;
use App\FMS\Reports\Job\Queries\WorkInProgressQuery;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

class ExportWorkInProgress extends AdminController
{
    public function __invoke(
        Request $request,
        WorkInProgressQuery $workInProgressQuery
    ) {
        try {
            return Excel::download(new WIPExport($request, $workInProgressQuery), 'work_in_progress_report.xlsx');
            return Excel::download(new WIPExport($request, $workInProgressQuery), 'work_in_progress_report.pdf', ExcelExcel::MPDF);
        } catch (\Exception $exception) {
            dd($exception);
        }
    }
}
