<?php
namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SupplierProductStockImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            // 0 => new SuppliersImport(),
            1 => new ProductImport(),
            // 2 => new StockImport(),
        ];
    }
}
