<?php

namespace App\FMS\Reports\Product\Queries;

use App\FMS\Filters\AdvanceQueryFilter;
use App\FMS\Site\Traits\FilterSiteByUserTrait;
use Illuminate\Database\Query\Expression;
use Illuminate\Http\Request;

class ProductQuery
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
            ->join('tbl_suppliers', 'tbl_suppliers.id', 'tbl_products.supplier_id')
            ->join('tbl_product_categories', 'tbl_product_categories.id', 'tbl_products.category_id')
            ->select(
                new Expression('CONCAT(tbl_products.supplier_id, "-", tbl_products.id) as code'),
                'tbl_products.name as range',
                'tbl_products.alias as alias',
                'tbl_products.price_base as price_base',
                new Expression('
                    if("'.$returnNumeric.' = 1", 
                        tbl_products.list_cost, 
                        CONCAT("$", tbl_products.list_cost)
                    ) as list
                '),
                new Expression('
                    if("'.$returnNumeric.' = 1", 
                        tbl_products.list_cost, 
                        CONCAT("$", tbl_products.list_cost)
                    ) as landed
                '),
                'sites.name as site_name',
                'tbl_suppliers.trading_name as supplier_name',
                'tbl_product_categories.name as category_name',
                'tbl_products.id',
                'tbl_products.created_at as added_date',
                new Expression('CONCAT(ROUND(JSON_EXTRACT(tbl_products.trade_sell, "$.gp"), 2), "%") as gp'),
                new Expression('CONCAT(ROUND(JSON_EXTRACT(tbl_products.retail_sell, "$.gp"), 2), "%") as mogp'),
                new Expression('CONCAT(ROUND(JSON_EXTRACT(tbl_products.installed, "$.gp"), 2), "%") as installedgp'),
                new Expression('
                    if("'.$returnNumeric.' = 1", 
                        ROUND(JSON_EXTRACT(tbl_products.trade_sell, "$.with_gst"), 2), 
                        CONCAT("$", ROUND(JSON_EXTRACT(tbl_products.trade_sell, "$.with_gst"), 2))
                    ) as trade
                '),
                new Expression('
                    if("'.$returnNumeric.' = 1", 
                        ROUND(JSON_EXTRACT(tbl_products.trade_sell, "$.margin"), 2), 
                        CONCAT("$", ROUND(JSON_EXTRACT(tbl_products.trade_sell, "$.margin"), 2))
                    ) as margin
                '),
                new Expression('
                    if("'.$returnNumeric.' = 1", 
                        ROUND(JSON_EXTRACT(tbl_products.retail_sell, "$.with_gst"), 2), 
                        CONCAT("$", ROUND(JSON_EXTRACT(tbl_products.retail_sell, "$.with_gst"), 2))
                    ) as motrade
                '),
                new Expression('
                    if("'.$returnNumeric.' = 1", 
                        ROUND(JSON_EXTRACT(tbl_products.retail_sell, "$.margin"), 2), 
                        CONCAT("$", ROUND(JSON_EXTRACT(tbl_products.retail_sell, "$.margin"), 2))
                    ) as momargin
                '),
                new Expression('
                    if("'.$returnNumeric.' = 1", 
                        ROUND(JSON_EXTRACT(tbl_products.installed, "$.with_gst"), 2), 
                        CONCAT("$", ROUND(JSON_EXTRACT(tbl_products.installed, "$.with_gst"), 2))
                    ) as installedtrade
                '),
                new Expression('
                    if("'.$returnNumeric.' = 1", 
                        ROUND(JSON_EXTRACT(tbl_products.installed, "$.margin"), 2), 
                        CONCAT("$", ROUND(JSON_EXTRACT(tbl_products.installed, "$.margin"), 2))
                    ) as installedmargin
                '),
                new Expression('
                    if("'.$returnNumeric.' = 1", 
                        ROUND(JSON_EXTRACT(tbl_products.retail_sell, "$.with_gst"), 2) / tbl_products.width, 
                        CONCAT("$", ROUND(JSON_EXTRACT(tbl_products.retail_sell, "$.with_gst"), 2) / tbl_products.width)
                    ) as motrade_square
                '),
                new Expression('
                    if("'.$returnNumeric.' = 1", 
                        ROUND(JSON_EXTRACT(tbl_products.installed, "$.with_gst"), 2) / tbl_products.width, 
                        CONCAT("$", ROUND(JSON_EXTRACT(tbl_products.installed, "$.with_gst"), 2) / tbl_products.width)
                    ) as installedtrade_square
                ')
            )
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
