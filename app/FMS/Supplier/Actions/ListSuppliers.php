<?php

namespace App\FMS\Supplier\Actions;

use App\FMS\Site\Traits\FilterSiteByUserTrait;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ListSuppliers extends AdminController
{
    use FilterSiteByUserTrait;

    public function __invoke(Request $request)
    {
        $user = $request->user();

        $site = $request->get('site_id');

        $supplier = $this->filterSiteByUser($user)
            ->join('tbl_suppliers', 'tbl_suppliers.site_id', 'sites.id')
            ->select(
                'tbl_suppliers.id as id',
                'tbl_suppliers.trading_name as name',
                'tbl_suppliers.site_id as site_id',
                'tbl_suppliers.created_at as created_at'
            );
        
        if ($site) {
            $supplier = $supplier->where('tbl_suppliers.site_id', $site);
        }

        $supplier = $supplier
            ->latest()
            ->get();
            
        return $this->sendSuccessResponse($supplier->toArray());
    }
}
