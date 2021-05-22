<?php

namespace App\FMS\Supplier\Actions;

use App\FMS\Site\Traits\FilterSiteByUserTrait;
use App\FMS\Supplier\Queries\LatestSupplier;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class IndexSupplier extends AdminController
{   
    use FilterSiteByUserTrait;

    public function __construct()
    {
        $this->middleware(['permission:suppliers']);
    }

    public function __invoke(Request $request, LatestSupplier $latestSupplier)
    {
        $user = $request->user();

        $supplier = $this->filterSiteByUser($user)
            ->join('tbl_suppliers', 'tbl_suppliers.site_id', 'sites.id')
            ->select(
                'tbl_suppliers.id as id'
            )
            ->whereNull('tbl_suppliers.deleted_at')
            ->orderBy('tbl_suppliers.updated_at', 'DESC')
            ->first();

        return $this->sendSuccessResponse($supplier ? $supplier->toArray() : []);
    }
}
