<?php

namespace App\FMS\Supplier\Actions;

use App\FMS\Supplier\Queries\SupplierReport;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ExportSuppliersReport extends AdminController
{
    public function __invoke(
        Request $request,
        SupplierReport $supplierReport
    ) {
        $suppliers = $supplierReport->export($request);
        $headings = collect([
            ['Id', 'Name', 'Address', 'Contact', 'Store']
        ]);
        return  $headings->merge($suppliers)->downloadExcel(
            'suppliers.xlsx',
            null,
            false
        );
    }
}
