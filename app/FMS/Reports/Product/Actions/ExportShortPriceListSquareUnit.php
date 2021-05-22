<?php

namespace App\FMS\Reports\Product\Actions;

use App\Exports\Product\FullPriceListBySupplierExport;
use App\Exports\Product\ShortPriceListSquareUnitExport;
use App\FMS\Reports\Product\Queries\ProductQuery;
use App\FMS\Reports\ReportType;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

class ExportShortPriceListSquareUnit extends AdminController
{
    public function __invoke(
        Request $request,
        ProductQuery $productQuery
    ) {
        $type = $request->get('type');
        try {
            if ($type === ReportType::PDF) {
                return Excel::download(new ShortPriceListSquareUnitExport($request, $productQuery), 'short_price_list_square_unit_report.pdf', ExcelExcel::MPDF);
            }

            return Excel::download(new ShortPriceListSquareUnitExport($request, $productQuery), 'short_price_list_square_unit_report.xls');
        } catch (\Exception $exception) {
            dd($exception);
        }
    }
}
