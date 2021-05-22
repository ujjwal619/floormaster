<?php

namespace App\FMS\Color\Actions;

use App\FMS\Site\Traits\FilterSiteByUserTrait;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ListColors extends AdminController
{
    use FilterSiteByUserTrait;

    public function __invoke(Request $request)
    {
        $user = $request->user();

        $site = $request->get('site_id');
        $supplier = $request->get('supplier_id');
        $product = $request->get('product_id');

        $colors = $this->filterSiteByUser($user)
            ->join('tbl_product_variants', 'tbl_product_variants.site_id', 'sites.id')
            ->join('tbl_products', 'tbl_products.id', 'tbl_product_variants.product_id')
            ->join('tbl_suppliers', 'tbl_suppliers.id', 'tbl_products.supplier_id')
            ->select(
                'tbl_product_variants.id as id',
                'tbl_product_variants.name as name',
                'tbl_product_variants.site_id as site_id',
                'tbl_product_variants.created_at as created_at'
            );
        
        if ($site) {
            $colors = $colors->where('tbl_product_variants.site_id', $site);
        }

        if ($supplier) {
            $colors = $colors->where('tbl_products.supplier_id', $supplier);
        }

        if ($product) {
            $colors = $colors->where('tbl_product_variants.product_id', $product);
        }

        $colors = $colors
            ->latest()
            ->get();
            
        return $this->sendSuccessResponse($colors->toArray());
    }
}
