<?php

namespace App\Exports\Product;

use App\Exports\FmExport;
use App\FMS\Reports\Product\Queries\ProductQuery;
use Illuminate\Http\Request;

class ShortPriceListSquareUnitExport extends FmExport
{
    private $request;
    private $productQuery;
    private $productData;
    protected $headerCount;

    public function __construct(
        Request $request, 
        ProductQuery $productQuery
    ) {
        $this->request = $request;
        $this->productQuery = $productQuery;
        $this->headerCount = 2;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $products = $this->productQuery->export($this->request);
        $productsWithAmount = $this->productQuery->export($this->request, true);

        $filters = $this->request->get('filters');

        $filterName = $this->filterName($filters);

        $headings = $this->headings($filterName);

        $data = $this->mapProductData($products);

        $footer = $this->footers($productsWithAmount);


        $productReport = $headings
                            ->merge($data)
                            ->merge($footer);

        return collect($productReport);
    }

    public function mapProductData($products): array
    {
        $products = collect($products)->map(function($product) {
            return [
                'code' => optional($product)->code,
                'range' => optional($product)->range,
                'alias' => optional($product)->alias,
                'price_base' => optional($product)->price_base,
                'site_name' => optional($product)->site_name,
                'motrade' => optional($product)->motrade,
                'installedtrade' => optional($product)->installedtrade,
                'motrade_square' => optional($product)->motrade_square,
                'installedtrade_square' => optional($product)->installedtrade_square,
            ];
        });

        $this->productData = $products;
        
        return $products->toArray();
    }

    private function footers($productsWithAmount)
    {
        
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
                'GST Inclusive Price List'
            ],
            [
                date('d M Y')
            ],
            collect($filterName)->chunk(1)->values()->toArray(),
            [
                'Code',
                'Range', 
                'Alias', 
                'Price Base', 
                'Store', 
                'Mat. Only', 
                'Installed',
                'Square Mat. Only', 
                'Square Installed',
            ]
        ]);
    }
}
