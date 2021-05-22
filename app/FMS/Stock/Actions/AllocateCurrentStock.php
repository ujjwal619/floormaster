<?php

namespace App\FMS\Stock\Actions;

use App\Data\Entities\Models\Stock\CurrentStock;
use App\FMS\Core\Traits\GetEntity;
use App\FMS\Job\Manager as JobManager;
use App\FMS\Memo\Manager as MemoManager;
use App\FMS\Stock\Events\CalculateStockTotal;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AllocateCurrentStock extends AdminController
{
    use GetEntity;

    public function __invoke(
        CurrentStock $currentStock,
        Request $request,
        DatabaseManager $databaseManager,
        JobManager $jobManager,
        MemoManager $memoManager
    ) {
        $request->validate([
            'amount' => 'required|numeric',
        ]);

        $details = $request->all();

        return $databaseManager->transaction(function () use (
            $details,
            $currentStock,
            $databaseManager,
            $jobManager,
            $memoManager
        ) {
            try {
                $soldAmount = $currentStock->sold + array_get($details, 'amount');
                $currentStock = $currentStock->fresh(['color.product.site', 'color.stock']);
                $color = $currentStock->color;
                $stock = $currentStock->stock;
                $currentStock->fill(['sold' => $soldAmount])->save();
                $currentStockForSell = $stock->current_stock_total_for_sell - $details['amount'];
                $site = $color->product->site;

                if ($color->reorder && ($currentStockForSell-$color->reorder) < 0 && $site->stock_below_reorder_user_id) {
                    $memoDetails = [
                        'subject' => 'Stock Level Warning',
                        'details' => 'Re-Order Alert. ' . $color->product->name . ' ' . $color->name . 
                            ' has only ' . $currentStockForSell . ' units for sale. Re-Order',
                        'date' => date('Y-m-d'),
                        'time' => date('h:i'),
                        'user_id' => $site->stock_below_reorder_user_id,
                        'further_action' => true,
                    ];
    
                    $memoManager->create($color, $memoDetails);
                }

                if (
                    array_get($details, 'job_id') &&
                    $job = $jobManager->find(array_get($details, 'job_id'))
                ) {
                    if (
                        array_get($details, 'job_material_id') &&
                        $jobMaterial = $jobManager->findJobMaterialById(array_get($details, 'job_material_id'))
                    ) {
                        $allocatedTotal = $jobMaterial->allocated + array_get($details, 'amount');
                        $jobMaterial->fill([
                            'allocated' => $allocatedTotal,
                            'act_on' => $jobMaterial->quantity - $allocatedTotal
                        ])->save();
                    }

                    $details['client'] = $job->trading_name;
                    $details['project'] = $job->project;
                }

                $details['variant_id'] = $currentStock->color->id;
                $details['site_id'] = $currentStock->site_id;
                $currentStock->allocations()->create($details);
                event(new CalculateStockTotal($color));
                $databaseManager->commit();

                return $this->sendSuccessResponse([], 'Successfully allocated current stock.');
            } catch (\Exception $exception) {
                $databaseManager->rollBack();
                dd($exception);

                return $this->sendError('Could not allocate current stock.', Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        });
    }
}
