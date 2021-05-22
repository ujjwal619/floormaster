<?php

namespace App\FMS\Account\Actions;

use App\FMS\Site\Traits\FilterSiteByUserTrait;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ListAccount extends AdminController
{
    use FilterSiteByUserTrait;

    public function __invoke(Request $request)
    {
        $user = $request->user();

        $familyId = $request->get('family_id');
        $siteId = $request->get('site_id');

        $supplier = $this->filterSiteByUser($user)
            ->join('tbl_suppliers', 'tbl_suppliers.site_id', 'sites.id')
            ->select(
                'tbl_suppliers.id as id',
                'tbl_suppliers.trading_name as name',
                'tbl_suppliers.site_id as site_id',
                'tbl_suppliers.created_at as created_at'
            );
        
        if ($siteId) {
            $supplier = $supplier->where('tbl_suppliers.site_id', $siteId);
        }

        $supplier = $supplier
            ->latest()
            ->get();
            
        return $this->sendSuccessResponse($supplier->toArray());
    }
}
