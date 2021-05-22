<?php

namespace App\FMS\Product;

use App\Data\Entities\Models\Product\Product;

class Manager
{
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getBySite(int $siteId)
    {
        return $this->product->newQuery()
            ->with(['supplier', 'productVariants'])
            ->join('tbl_suppliers', 'tbl_suppliers.id', 'tbl_products.supplier_id')
            ->where('tbl_suppliers.site_id', $siteId)
            ->select(
                'tbl_products.id as id',
                'tbl_products.name as name',
                'tbl_products.alias as alias',
                'tbl_products.upc as upc',
                'tbl_products.price_base as price_base',
                'tbl_products.category_id as category_id',
                'tbl_products.supplier_id as supplier_id',
                'tbl_products.list_cost as list_cost',
                'tbl_products.discount as discount',
                'tbl_products.levy as levy',
                'tbl_products.net_cost as net_cost',
                'tbl_products.gst as gst',
                'tbl_products.width as width',
                'tbl_products.unit as unit',
                'tbl_products.trade_sell as trade_sell',
                'tbl_products.retail_sell as retail_sell',
                'tbl_products.installed as installed',
                'tbl_products.act_on_me as act_on_me',
                'tbl_products.exclude_from_report as exclude_from_report'
            )
            ->get();
    }

    public function findWhere(array $conditions = [])
    {
        return $this->product->where($conditions)->first();
    }
}
