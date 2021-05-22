<?php

namespace App\FMS\Reports\Job\Actions;

use App\Exports\MITExport;
use App\FMS\Reports\Job\Queries\MITQuery;
use App\FMS\Reports\ReportType;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelExcel;

class ExportMIT extends AdminController
{
    public function __invoke(
        Request $request,
        MITQuery $mITQuery
    ) {
        $type = $request->get('type');
        try {
            if ($type === ReportType::PDF) {
                return Excel::download(new MITExport($request, $mITQuery), 'mit_report.pdf', ExcelExcel::MPDF);
            }
            
            return Excel::download(new MITExport($request, $mITQuery), 'mit_report.xlsx');
        } catch (\Exception $exception) {
            dd($exception);
        }
    }
}
