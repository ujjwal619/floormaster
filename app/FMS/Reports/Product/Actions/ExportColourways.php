<?php

namespace App\FMS\Reports\Product\Actions;

use App\Exports\ColourwaysExport;
use App\FMS\Reports\Product\Queries\ColourwaysQuery;
use App\FMS\Reports\ReportType;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

class ExportColourways extends AdminController
{
    public function __invoke(
        Request $request,
        ColourwaysQuery $colourwaysQuery
    ) {
        $type = $request->get('type');
        try {
            if ($type === ReportType::PDF) {
                return Excel::download(new ColourwaysExport($request, $colourwaysQuery), 'colourways_report.pdf', ExcelExcel::MPDF);
            }
            
            return Excel::download(new ColourwaysExport($request, $colourwaysQuery), 'colourways_report.xls');
        } catch (\Exception $exception) {
            dd($exception);
        }
    }
}
