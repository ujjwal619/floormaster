<?php

namespace App\FMS\Stock\Actions\BackOrder;

use App\FMS\Stock\Events\CalculateStockTotal;
use App\FMS\Stock\Models\BackOrder;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Database\DatabaseManager;

class UnlinkBackOrder extends AdminController
{
    public function __invoke(BackOrder $backOrder, DatabaseManager $databaseManager)
    {
        try {
            return $databaseManager->transaction(function () use ($backOrder, $databaseManager) {
                $backOrder->load(['futureStock', 'color', 'jobMaterial']);
                $futureStock= $backOrder->futureStock;
                $color = $backOrder->color;
                
                if($jobMaterial = $futureStock->jobMaterial) {
                    $jobMaterial->fill(['allocated' => $jobMaterial->allocated - $backOrder->amount])->save();
                }

                $futureStock->fill(['sold' => $futureStock->sold - $backOrder->amount])->save();
                $backOrder->fill(['is_linked' => false])->save();

                event(new CalculateStockTotal($color));
                $databaseManager->commit();

                return $this->sendSuccessResponse([], 'Successfully unlinked back order.');
            });
        } catch (\Exception $exception) {
            $databaseManager->rollBack();
        }

        return $this->sendError('Could not unlink back order.');
    }
}
