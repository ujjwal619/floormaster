<?php

namespace App\FMS\Stock\Actions\Allocation;

use App\FMS\Stock\Events\CalculateStockTotal;
use App\FMS\Stock\Models\Allocation;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Database\DatabaseManager;

class DeleteAllocation extends AdminController
{
    public function __invoke(Allocation $allocation, DatabaseManager $databaseManager)
    {
        try {
            return $databaseManager->transaction(function () use ($allocation, $databaseManager) {
                $allocation->load(['currentStock', 'color', 'jobMaterial']);
                $currentStock= $allocation->currentStock;
                $color = $allocation->color;
                
                if($jobMaterial = $allocation->jobMaterial) {
                    $jobMaterial->fill(['allocated' => $jobMaterial->allocated - $allocation->amount])->save();
                }

                $currentStock->fill(['sold' => $currentStock->sold - $allocation->amount])->save();
                $allocation->delete();
                event(new CalculateStockTotal($color));

                $databaseManager->commit();

                return $this->sendSuccessResponse([], 'Successfully deleteed allocation.');
            });
        } catch (\Exception $exception) {
            $databaseManager->rollBack();
        }

        return $this->sendError('Could not delete allocation.');
    }
}
