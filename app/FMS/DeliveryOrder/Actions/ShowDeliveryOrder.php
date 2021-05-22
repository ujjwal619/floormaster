<?php

namespace App\FMS\DeliveryOrder\Actions;

use App\Constants\DBTable;
use App\Data\Entities\Models\Stock\CurrentOrder;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ShowDeliveryOrder extends AdminController
{
    public function __invoke(CurrentOrder $currentOrder, Request $request)
    {
        $sites = $request->user()->getSiteIds();
        if (!$sites->contains($currentOrder->site_id)) {
            abort('401', 'Unauthorized site.');
        }



        return $this->sendSuccessResponse($currentOrder->fresh([
            'futureStocks.color.product',
            'futureStocks.currentStocks',
            'job.primarySalesPerson',
            'site'
        ])->toArray());
    }
}
