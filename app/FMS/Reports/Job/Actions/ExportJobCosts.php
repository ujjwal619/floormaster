<?php

namespace App\FMS\Reports\Job\Actions;

use App\Exports\JobCostsExport;
use App\Exports\TakingExport;
use App\FMS\Reports\Job\Queries\JobCostsQuery;
use App\FMS\Reports\Job\Queries\TakingQuery;
use App\FMS\Reports\ReportType;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelExcel;

class ExportJobCosts extends AdminController
{
    public function __invoke(
        Request $request,
        JobCostsQuery $jobCostsQuery
    ) {
        $type = $request->get('type');
        try {
            if ($type === ReportType::PDF) {
                return Excel::download(new JobCostsExport($request, $jobCostsQuery), 'job_costs_report.pdf', ExcelExcel::MPDF);
            }
            
            return Excel::download(new JobCostsExport($request, $jobCostsQuery), 'job_costs_report.xlsx');
        } catch (\Exception $exception) {
            dd($exception);
        }
    }
}
