<?php

namespace App\FMS\Stock\Actions\Allocation;

use App\Data\Entities\Models\Stock\CurrentStock;
use App\FMS\Stock\Models\Allocation;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Database\DatabaseManager;

class MoveAllocationToCurrentStock extends AdminController
{
    public function __invoke(
        Allocation $allocation, 
        CurrentStock $currentStock,
        DatabaseManager $databaseManager
    ) {

        return $databaseManager->transaction(function () use (
            $allocation, 
            $currentStock,
            $databaseManager
        ) {
            try {
                $allocationAmount = $allocation->amount;
                $amountToBeMoved = $allocationAmount;
                $forSell = $currentStock->size - $currentStock->sold;
                if ($allocationAmount > $forSell) {
                    $amountToBeMoved = $forSell;
                }

                $allocation->load(['currentStock']);
                $allocationCurrentStock = $allocation->currentStock;
                $allocationCurrentStock->fill(['sold' => $allocationCurrentStock->sold - $amountToBeMoved])->save();
                $allocation->fill(['amount' => $allocationAmount - $amountToBeMoved])->save();
                $currentStock->fill(['sold' => $currentStock->sold + $amountToBeMoved])->save();
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
                $currentStock->allocations()->create($backOrderData);
                $databaseManager->commit();
                
                return $this->sendSuccessResponse([], 'Successfully moved allocation to current stock.');
            } catch (\Exception $exception) {
                $databaseManager->rollback();

                return $this->sendError('Could not move allocation to current stock.');
            }
        });

    }
}
