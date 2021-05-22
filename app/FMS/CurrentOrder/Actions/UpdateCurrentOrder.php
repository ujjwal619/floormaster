<?php

namespace App\FMS\CurrentOrder\Actions;

use App\Data\Entities\Models\Stock\CurrentOrder;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class UpdateCurrentOrder extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:orders.update.order']);
    }

    public function __invoke(Request $request, CurrentOrder $currentOrder)
    {
        $details = $request->all('due_date');

        if (!$currentOrder->fill(['due_date' => array_get($details, 'due_date')])->save()) {
            abort('204', 'Could not update Current Order.');
        }

        return $this->sendSuccessResponse([], 'Current Order updated successfully.');
    }
}
