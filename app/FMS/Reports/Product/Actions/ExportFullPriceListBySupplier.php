<?php

namespace App\FMS\Reports\Product\Actions;

use App\Exports\Product\FullPriceListBySupplierExport;
use App\FMS\Reports\Product\Queries\ProductQuery;
use App\FMS\Reports\ReportType;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

class ExportFullPriceListBySupplier extends AdminController
{
    public function __invoke(
        Request $request,
        ProductQuery $productQuery
    ) {
        $type = $request->get('type');
        try {
            if ($type === ReportType::PDF) {
                return Excel::download(new FullPriceListBySupplierExport($request, $productQuery), 'full_price_list_by_supplier_report.pdf', ExcelExcel::MPDF);
            }

            return Excel::download(new FullPriceListBySupplierExport($request, $productQuery), 'full_price_list_by_supplier_report.xls');
        } catch (\Exception $exception) {
            dd($exception);
        }
    }
}
