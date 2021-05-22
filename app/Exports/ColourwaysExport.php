<?php

namespace App\Exports;

use App\FMS\Reports\Product\Queries\ColourwaysQuery;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ColourwaysExport extends FmExport
{
    private $request;
    private $colourwaysQuery;
    private $productData;
    protected $headerCount;

    public function __construct(
        Request $request, 
        ColourwaysQuery $colourwaysQuery
    ) {
        $this->request = $request;
        $this->colourwaysQuery = $colourwaysQuery;
        $this->headerCount = 2;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $products = $this->colourwaysQuery->export($this->request);
        $productsWithAmount = $this->colourwaysQuery->export($this->request, true);

        $filters = $this->request->get('filters');

        $filterName = $this->filterName($filters);

        $headings = $this->headings($filterName);

        $data = $this->mapProductData($products);

        $productReport = $headings
                            ->merge($data);

        return collect($productReport);
    }

    public function mapProductData($products): array
    {
        $products = collect($products)->map(function($product) {
            return [
                'code' => optional($product)->code,
                'supplier_name' => optional($product)->supplier_name,
                'range' => optional($product)->range,
                'colour_name' => optional($product)->colour_name,
                'site_name' => optional($product)->site_name,
            ];
        });

        $this->productData = $products;
        
        return $products->toArray();
    }

    private function filterName($filters)
    {
        $filterName = ['All Report'];
        $this->headerCount++;
        $storeName = array_get($filters, 'site_name', []);
        $supplier = array_get($filters, 'supplier_name', []);
        $category = array_get($filters, 'category_name', []);

        if ($storeName && array_get($storeName, 'equals')) {
            $filterName = ['Store Name is ' . array_get($storeName, 'equals') . ' '];
        }
        if ($supplier && array_get($supplier, 'equals')) {
            array_push($filterName, 'Supplier is ' . array_get($supplier, 'equals') . ' ');
            $this->headerCount++;
        }

        if ($category && array_get($category, 'equals')) {
            array_push($filterName, 'Category is ' . array_get($supplier, 'equals') . ' ');
            $this->headerCount++;
        }

        return $filterName;
    }

    private function headings($filterName)
    {
        return collect([
            [
                'GST Inclusive Price List',
            ],
            [
                date('d M Y')
            ],
            collect($filterName)->chunk(1)->values()->toArray(),
            [
                'Code',
                'Supplier', 
                'Range', 
                'Colour', 
                'Store', 
            ]
        ]);
    }
}
