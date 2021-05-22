<?php

namespace App\FMS\Reports\Product\Queries;

use App\FMS\Filters\AdvanceQueryFilter;
use App\FMS\Site\Traits\FilterSiteByUserTrait;
use Illuminate\Database\Query\Expression;
use Illuminate\Http\Request;

class ColourwaysQuery
{
    use FilterSiteByUserTrait;

    public function run(Request $request)
    {
        return $this->getFilteredProducts($request)
            ->paginate($request->get('per_page', config('fms.paginationLimit')));
    }

    public function export(Request $request, $returnNumeric = false)
    {
        return $this->getFilteredProducts($request, $returnNumeric)
            ->get();
    }

    private function getFilteredProducts(Request $request, $returnNumeric = false)
    {
        $user = $request->user();

        return $this->filterSiteByUser($user)
            ->join('tbl_products', 'tbl_products.site_id', 'sites.id')
            ->join('tbl_product_variants', 'tbl_product_variants.product_id', 'tbl_products.id')
            ->join('tbl_suppliers', 'tbl_suppliers.id', 'tbl_products.supplier_id')
            ->join('tbl_product_categories', 'tbl_product_categories.id', 'tbl_products.category_id')
            ->select(
                new Expression('CONCAT(tbl_products.supplier_id, "-", tbl_products.id) as code'),
                'tbl_products.name as range',
                'sites.name as site_name',
                'tbl_suppliers.trading_name as supplier_name',
                'tbl_product_categories.name as category_name',
                'tbl_products.id',
                'tbl_product_variants.name as colour_name'
            )
            ->groupBy('tbl_product_variants.id')
            ->filter($this->getFilter());
    }

    private function getFilter()
    {
        // @var AdvanceQueryFilter
        $filter = app(AdvanceQueryFilter::class);

        $filter->setFilterableColumns($this->getFilterableColumns())
            ->setSortableColumns([
                'code',
                'site_name',
                ]);

        return $filter;
    }

    private function getFilterableColumns()
    {
        return [
            'where' => [
                'site_name' => 'sites.name',     
                'supplier_name' => 'tbl_suppliers.trading_name',     
                'category_name' => 'tbl_product_categories.name'          
            ],
            'having' => [
            ],
        ];
    }
}
