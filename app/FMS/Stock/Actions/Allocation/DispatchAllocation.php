<?php

namespace App\FMS\Stock\Actions\Allocation;

use App\FMS\Account\Manager as AccountManager;
use App\FMS\Stock\Events\AllocationDispatched;
use App\FMS\Stock\Events\CalculateStockTotal;
use App\FMS\Stock\Manager as StockManager;
use App\FMS\Stock\Models\Allocation;
use App\FMS\TransactionJournal\Manager as TransactionJournalManager;
use App\FMS\TransactionJournal\ValueObjects\TransactionJournalType;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class DispatchAllocation extends AdminController
{
    public function __invoke(
        Allocation $allocation, 
        Request $request, 
        DatabaseManager $databaseManager
    ) {
        $request->validate([
            'amount' => 'required|numeric',
            'date' => 'nullable|date|required'
        ]);

        $amount = $request->get('amount');
        $date = $request->get('date');
        $transactionJournalId = $request->get('transaction_journal_id', null);
        $returnLocation = $request->get('return_location', '');

        return $databaseManager->transaction(function () use (
            $databaseManager, 
            $amount, 
            $allocation,
            $date,
            $returnLocation,
            $transactionJournalId
        ) {
            try {
                $was = $allocation->amount;
                $jobMaterial = $allocation->jobMaterial;
                $currentStock = $allocation->currentStock;
                $futureStock = $currentStock->futureStock;
                
                throw_if($allocation->amount - $amount < 0, new \Exception('Allocation already dispatched'));

                $allocation->load('color.product.supplier', 'jobMaterial', 'currentStock.futureStock');
                
                $allocation->fill(['amount' => $allocation->amount - $amount])->save();
                
                $dispatchTotal = $currentStock->unit_cost * $amount;
                if ($futureStock) {
                    $discountedUnitPrice = $futureStock->list_price - (($futureStock->list_price * $futureStock->discount) / 100);
                    $dispatchTotal = $discountedUnitPrice * $amount;
                }

                $currentStock->fill(['size' => $currentStock->size - $amount, 'sold' => $currentStock->sold - $amount])->save();

                if ($jobMaterial) {
                    $jobMaterial->fill([
                        'allocated' => $jobMaterial->allocated - $amount,
                        'dispatched' => $jobMaterial->dispatched + $amount,
                    ])->save();
                }

                // if($futureStock && $futureStock->job_material_id && $jobMaterial) {
                //     $jobMaterial->fill(['on_order' => $jobMaterial->on_order - $amount,])->save();
                // }

                $dispatchData = [
                    'job_id' => $allocation->job_id,
                    'job_material_id' => $allocation->job_material_id,
                    'date' => $date ?? $allocation->created_at,
                    'amount' => $amount,
                    'return_location' => $returnLocation,
                    'supplier_product_color' => sprintf(
                        '%s: %s %s',
                        $allocation->color->product->supplier->trading_name,
                        $allocation->color->product->name,
                        $allocation->color->name
                    ),
                    'variant_id' => $allocation->variant_id,
                    'current_stock_id' => $allocation->current_stock_id,
                    'site_id' => $allocation->site_id,
                    'was' => $was,
                    'left' => $allocation->amount,
                    'total' => $dispatchTotal,
                ];

                $allocationDispatch = $allocation->dispatches()->create($dispatchData);

                event(new AllocationDispatched($allocation, $allocationDispatch, $date, $amount, $transactionJournalId));

                event(new CalculateStockTotal($allocation->color));

                $databaseManager->commit();

                return $this->sendSuccessResponse($allocation->fresh()->toArray(), 'Successfully dispatched allocation.');
            } catch (\Exception $exception) {
                $databaseManager->rollBack();
                dd($exception);
                
                return $this->sendError('Could not dispatch allocation');
            }
        });
    }
}
