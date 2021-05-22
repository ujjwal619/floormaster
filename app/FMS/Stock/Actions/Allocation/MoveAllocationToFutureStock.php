<?php

namespace App\FMS\Stock\Actions\Allocation;

use App\Data\Entities\Models\Stock\FutureStock;
use App\FMS\Stock\Models\Allocation;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Database\DatabaseManager;

class MoveAllocationToFutureStock extends AdminController
{
    public function __invoke(
        Allocation $allocation, 
        FutureStock $futureStock,
        DatabaseManager $databaseManager
    ) {
        try {
            $allocationAmount = $allocation->amount;
            $amountToBeMoved = $allocationAmount;
            $forSell = $futureStock->quantity - $futureStock->sold > 0 ? 
                $futureStock->quantity - $futureStock->sold - $futureStock->received : 0;
            if ($allocationAmount > $forSell) {
                $amountToBeMoved = $forSell;
            }

            $allocation->load(['currentStock']);
            $allocationCurrentStock = $allocation->currentStock;
            $allocationCurrentStock->fill(['sold' => $allocationCurrentStock->sold - $amountToBeMoved])->save();
            $allocation->fill(['amount' => $allocationAmount - $amountToBeMoved])->save();
            $futureStock->fill(['sold' => $futureStock->sold + $amountToBeMoved])->save();
            $allocationData = $allocation->toArray();
            $backOrderData = array_except($allocationData, [
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
            
            return $this->sendSuccessResponse([], 'Successfully moved allocation to future stock.');
        } catch (\Exception $exception) {
            $databaseManager->rollback();
            dd($exception);

            return $this->sendError('Could not move allocation to future stock.');
        }
    }
}
