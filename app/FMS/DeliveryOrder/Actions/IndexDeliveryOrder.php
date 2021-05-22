<?php

namespace App\FMS\DeliveryOrder\Actions;

use App\Constants\DBTable;
use App\Data\Entities\Models\Stock\CurrentOrder;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class IndexDeliveryOrder extends AdminController
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        $deliveryOrder = $user->newQuery()
        ->join('user_sites', 'user_sites.user_id', 'auth_users.id')
        ->join('sites', 'sites.id', 'user_sites.site_id')
        ->where('user_sites.user_id', $user->id)
        ->join(DBTable::CURRENT_ORDER, DBTable::CURRENT_ORDER.'.site_id', 'sites.id')
        ->select(
            DBTable::CURRENT_ORDER.'.id as id'
        )
        ->where(DBTable::CURRENT_ORDER.'.is_archived', true)
        ->orderBy(DBTable::CURRENT_ORDER.'.updated_at', 'DESC')
        ->first();

        return $this->sendSuccessResponse($deliveryOrder ? $deliveryOrder->toArray() : []);
    }
}
