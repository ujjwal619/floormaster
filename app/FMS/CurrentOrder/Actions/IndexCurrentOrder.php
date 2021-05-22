<?php

namespace App\FMS\CurrentOrder\Actions;

use App\FMS\Site\Traits\FilterSiteByUserTrait;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IndexCurrentOrder extends AdminController
{
    use FilterSiteByUserTrait;

    public function __construct()
    {
        // $this->middleware(['permission:payables']);
    }

    public function __invoke(Request $request)
    {
        $user = $request->user();

        $currentOrder = $this->filterSiteByUser($user)
            ->join('tbl_current_orders', 'tbl_current_orders.site_id', 'sites.id')
            ->where('tbl_current_orders.is_archived', false)
            ->select(
                'tbl_current_orders.id as id'
            )
            ->orderBy('tbl_current_orders.updated_at', 'DESC')
            ->first();

        return $this->sendSuccessResponse($currentOrder ? $currentOrder->toArray() : []);
    }
}
