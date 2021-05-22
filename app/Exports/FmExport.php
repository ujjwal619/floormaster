<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

abstract class FmExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements 
    FromCollection, 
    WithStyles,
    WithCustomValueBinder,
    ShouldAutoSize
{
    public function styles(Worksheet $sheet)
    {
        $columnHeaderRow = $this->headerCount + 1;
        for($i = 1; $i <= $this->headerCount; $i++) {
            $sheet->getStyle($i)->getFont()->setBold(true);
            $sheet->mergeCells(sprintf('A%s:E%s', $i, $i));
        }
        
        return [
            $columnHeaderRow    => ['font' => ['bold' => true]],
        ];
    }
}
