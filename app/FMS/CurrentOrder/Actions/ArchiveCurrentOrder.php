<?php

namespace App\FMS\CurrentOrder\Actions;

use App\Data\Entities\Models\Stock\CurrentOrder;
use App\StartUp\BaseClasses\Controller\AdminController;

class ArchiveCurrentOrder extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:orders.delete.order']);
    }

    public function __invoke(CurrentOrder $currentOrder)
    {
        if ($currentOrder->fill(['is_archived' => true])->save()) {
            $currentOrder->futureStocks()->update(['is_archived' => true]);

            return $this->sendSuccessResponse([], 'Current Order archived successfully.');
        }

        return $this->sendError('Could not archive current order');
    }
}
