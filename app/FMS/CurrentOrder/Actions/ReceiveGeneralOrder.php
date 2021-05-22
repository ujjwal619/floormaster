<?php

namespace App\FMS\CurrentOrder\Actions;

use App\Data\Entities\Models\Stock\CurrentOrder;
use App\Data\Entities\Models\Stock\FutureStock;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ReceiveGeneralOrder extends AdminController
{
    public function __construct()
    {
        // $this->middleware(['permission:billing.access.edit.bills']);
    }

    public function __invoke(
        CurrentOrder $currentOrder, 
        FutureStock $futureStock, 
        Request $request
    ) {
        $request->validate([
            'size' => 'numeric|required',
            'delivery_date' => 'date|required',
        ]);

        $details = $request->all();

        $futureStock->fill([
            'received' => $futureStock->received + $details['size']
        ])->save();

        $currentOrder->fill([
            'last_date_received' => $details['delivery_date']
        ])->save();

        return $this->sendSuccessResponse($futureStock->toArray(), 'General order received successfully.');
    }
}
