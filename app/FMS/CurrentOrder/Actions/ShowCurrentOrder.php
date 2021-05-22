<?php

namespace App\FMS\CurrentOrder\Actions;

use App\Data\Entities\Models\Stock\CurrentOrder;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ShowCurrentOrder extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:orders']);
    }

    public function __invoke(CurrentOrder $currentOrder, Request $request)
    {
        $sites = $request->user()->getSiteIds();
        if (!$sites->contains($currentOrder->site_id)) {
            abort('401', 'Unauthorized site.');
        }

        if ($currentOrder->is_archived) {
            abort('404', 'Current order not found.');
        }

        return $this->sendSuccessResponse($currentOrder->fresh([
            'futureStocks.color.product.supplier', 
            'futureStocks.currentStocks',
            'job.primarySalesPerson',
            'site'
        ])->toArray());
    }
}
