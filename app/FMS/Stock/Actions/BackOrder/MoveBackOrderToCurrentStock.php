<?php

namespace App\FMS\Stock\Actions\BackOrder;

use App\Data\Entities\Models\Stock\CurrentStock;
use App\FMS\Stock\Models\BackOrder;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Database\DatabaseManager;

class MoveBackOrderToCurrentStock extends AdminController
{
    public function __invoke(
        BackOrder $backOrder, 
        CurrentStock $currentStock,
        DatabaseManager $databaseManager
    ) {

        return $databaseManager->transaction(function () use (
            $backOrder, 
            $currentStock,
            $databaseManager
        ) {
            try {
                $backOrderAmount = $backOrder->amount;
                $amountToBeMoved = $backOrderAmount;
                $forSell = $currentStock->size - $currentStock->sold;
                if ($backOrderAmount > $forSell) {
                    $amountToBeMoved = $forSell;
                }
                $backOrder->load(['futureStock']);
                $backOrderFutureStock = $backOrder->futureStock;
                $backOrderFutureStock->fill(['sold' => $backOrderFutureStock->sold - $amountToBeMoved])->save();
                $currentStock->fill(['sold' => $currentStock->sold + $amountToBeMoved])->save();
                $backOrder->fill(['amount' => $backOrderAmount - $amountToBeMoved])->save();
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
                $currentStock->allocations()->create($backOrderData);
                $databaseManager->commit();
                
                return $this->sendSuccessResponse([], 'Successfully moved backorder to current stock.');
            } catch (\Exception $exception) {
                $databaseManager->rollback();

                return $this->sendError('Could not move backorder to current stock.');
            }
        });

    }
}
