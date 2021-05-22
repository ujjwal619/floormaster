<?php

namespace App\FMS\CurrentOrder\Actions;

use App\Data\Entities\Models\Stock\CurrentOrder;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class CreateCurrentOrder extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:orders.add.order']);
    }

    public function __invoke(CurrentOrder $currentOrder, Request $request)
    {
        $request->validate([
            'site_id' => 'required|numeric',
            'due_date' => 'required|date', //quoted_delivery_date
            'costed_price' => 'required|numeric',
            'sales_rep' => 'required',
        ]);

        $details = $request->all();

        $currentOrder = $currentOrder->newInstance()->create($details);

        $futureStocks = array_get($details, 'future_stocks');
        // dd($futureStocks);

        if ($futureStocks) {
            $currentOrder->futureStocks()->createMany($futureStocks);
        }

        return $this->sendSuccessResponse($currentOrder->toArray(), 'Current Order Created successfully.');
    }
}
