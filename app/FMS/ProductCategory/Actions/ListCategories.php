<?php

namespace App\FMS\ProductCategory\Actions;

use App\FMS\Site\Traits\FilterSiteByUserTrait;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ListCategories extends AdminController
{
    use FilterSiteByUserTrait;

    public function __invoke(Request $request)
    {
        $user = $request->user();

        $site = $request->get('site_id');

        $categories = $this->filterSiteByUser($user)
            ->join('tbl_product_categories', 'tbl_product_categories.site_id', 'sites.id')
            ->select(
                'tbl_product_categories.id as id',
                'tbl_product_categories.title as title',
                'tbl_product_categories.name as name',
                'tbl_product_categories.description as description',
                'tbl_product_categories.site_id as site_id',
                'sites.name as site_name',
                'tbl_product_categories.inventory_account_id as inventory_account_id',
                'tbl_product_categories.cos_account_id as cos_account_id',
                'tbl_product_categories.created_at as created_at'
            )
            ->whereNull('tbl_product_categories.deleted_at');
        
        if ($site) {
            $categories = $categories->where('tbl_product_categories.site_id', $site);
        }

        $categories = $categories
            ->latest()
            ->get();
            
        return $this->sendSuccessResponse($categories->toArray());
    }
}
