<?php

namespace App\FMS\Stock\Actions\BackOrder;

use App\Data\Entities\Models\Stock\FutureStock;
use App\FMS\Stock\Models\BackOrder;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Database\DatabaseManager;

class MoveBackOrderToFutureStock extends AdminController
{
    public function __invoke(
        BackOrder $backOrder, 
        FutureStock $futureStock,
        DatabaseManager $databaseManager
    ) {
        try {
            $backOrderAmount = $backOrder->amount;
            $amountToBeMoved = $backOrderAmount;
            $forSell = $futureStock->quantity - $futureStock->sold > 0 ? 
                $futureStock->quantity - $futureStock->sold - $futureStock->received : 0;
            if ($backOrderAmount > $forSell) {
                $amountToBeMoved = $forSell;
            }

            $backOrder->load(['futureStock']);
            $backOrderFutureStock = $backOrder->futureStock;
            $backOrderFutureStock->fill(['sold' => $backOrderFutureStock->sold - $amountToBeMoved])->save();
            $backOrder->fill(['amount' => $backOrderAmount - $amountToBeMoved])->save();
            $futureStock->fill(['sold' => $futureStock->sold + $amountToBeMoved])->save();
            $backOrderData = $backOrder->toArray();
            $backOrderData = array_except($backOrderData, [
                'id', 
                'future_stock_id',
                'created_at',
                'updated_at',
                'created_by_id',
                'updated_by_id',
                'deleted_by_id'
            ]);
            $backOrderData['amount'] = $amountToBeMoved;
            $futureStock->backOrders()->create($backOrderData);
            $databaseManager->commit();
            
            return $this->sendSuccessResponse([], 'Successfully moved backorder to future stock.');
        } catch (\Exception $exception) {
            $databaseManager->rollback();
            dd($exception);

            return $this->sendError('Could not move backorder to future stock.');
        }
    }
}
