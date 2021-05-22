<?php

namespace App\FMS\Stock\Actions\BackOrder;

use App\FMS\Stock\Events\CalculateStockTotal;
use App\FMS\Stock\Models\BackOrder;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\Request;

class UpdateBackOrder extends AdminController
{
    public function __invoke(BackOrder $backOrder, Request $request, DatabaseManager $databaseManager)
    {
        $request->validate([
            'amount' => 'required|numeric'
        ]);

        $details = $request->all();

        try {
            return $databaseManager->transaction(function () use ($backOrder, $details, $databaseManager) {
                $backOrder->load(['futureStock', 'color', 'jobMaterial']);
                $futureStock= $backOrder->futureStock;
                $color = $backOrder->color;
                
                if($jobMaterial = $futureStock->jobMaterial) {
                    $jobMaterial->fill(['allocated' => $jobMaterial->allocated - $backOrder->amount + $details['amount']])->save();
                }

                $futureStock->fill(['sold' => $futureStock->sold - $backOrder->amount + $details['amount']])->save();
                $backOrder->fill($details)->save();
                event(new CalculateStockTotal($color));

                $databaseManager->commit();

                return $this->sendSuccessResponse([], 'Successfully updated back order.');
            });
        } catch (\Exception $exception) {
            dd($exception);
            $databaseManager->rollBack();
        }

        return $this->sendError('Could not updated back order.');
    }
}
