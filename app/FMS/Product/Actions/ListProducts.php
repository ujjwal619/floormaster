<?php

namespace App\FMS\Product\Actions;

use App\FMS\Site\Traits\FilterSiteByUserTrait;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ListProducts extends AdminController
{
    use FilterSiteByUserTrait;

    public function __invoke(Request $request)
    {
        $user = $request->user();

        $site = $request->get('site_id');
        $supplier = $request->get('supplier_id');

        $products = $this->filterSiteByUser($user)
            ->join('tbl_products', 'tbl_products.site_id', 'sites.id')
            ->join('tbl_suppliers', 'tbl_suppliers.id', 'tbl_products.supplier_id')
            ->select(
                'tbl_products.id as id',
                'tbl_products.name as name',
                'tbl_products.site_id as site_id',
                'tbl_products.created_at as created_at'
            );
        
        if ($site) {
            $products = $products->where('tbl_products.site_id', $site);
        }

        if ($supplier) {
            $products = $products->where('tbl_products.supplier_id', $supplier);
        }

        $products = $products
            ->latest()
            ->get();
            
        return $this->sendSuccessResponse($products->toArray());
    }
}
