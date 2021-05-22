<?php

namespace App\FMS\Stock\Actions\Allocation;

use App\FMS\Stock\Events\CalculateStockTotal;
use App\FMS\Stock\Models\Allocation;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\Request;

class UpdateAllocation extends AdminController
{
    public function __invoke(Allocation $allocation, Request $request, DatabaseManager $databaseManager)
    {
        $request->validate([
            'amount' => 'required|numeric',
        ]);

        $details = $request->all();

        try {
            return $databaseManager->transaction(function () use ($allocation, $details, $databaseManager) {
                $allocation->load(['currentStock', 'color', 'jobMaterial']);
                $currentStock= $allocation->currentStock;
                $color = $allocation->color;
                
                if($jobMaterial = $allocation->jobMaterial) {
                    $jobMaterial->fill(['allocated' => $jobMaterial->allocated - $allocation->amount + $details['amount']])->save();
                }

                $currentStock->fill(['sold' => $currentStock->sold - $allocation->amount + $details['amount']])->save();
                $allocation->fill($details)->save();
                event(new CalculateStockTotal($color));

                $databaseManager->commit();

                return $this->sendSuccessResponse([], 'Successfully updated allocation.');
            });
        } catch (\Exception $exception) {
            $databaseManager->rollBack();
        }

        return $this->sendError('Could not updated allocation.');
    }
}
