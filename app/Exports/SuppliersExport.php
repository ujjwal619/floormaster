<?php

namespace App\Exports;

use App\FMS\Supplier\Queries\SupplierReport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;

class SuppliersExport implements FromCollection
{
    private $supplierReport;


    public function __construct(SupplierReport $supplierReport)
    {
        $this->supplierReport = $supplierReport;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(Request $request)
    {
        return $this->supplierReport->export($request);

    }
}
