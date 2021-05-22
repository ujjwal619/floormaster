<?php

namespace App\FMS\Supplier\Actions;

use App\Data\Entities\Models\Supplier\Supplier;
use App\FMS\Supplier\Events\PayableDeleted;
use App\FMS\Supplier\Models\Payable;
use App\StartUp\BaseClasses\Controller\AdminController;
use Exception;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\Request;

class DeleteSupplierPayable extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:payables.delete']);
    }

    public function __invoke(Payable $payable, Request $request, DatabaseManager $databaseManager)
    {
        return $databaseManager->transaction(function () use ($request, $databaseManager, $payable) {
            try {
                $isSuperUser = $request->user()->hasRole('super_admin');
                $from = getDateRange($isSuperUser, 'start'); 
                $to = getDateRange($isSuperUser, 'end'); 

                $payable1 = $payable->newQuery()
                    ->whereBetween('invoice_date', [$from, $to])
                    ->where('id', $payable->id)
                    ->first();
                
                throw_if(!$payable1, new Exception(
                    'Payables between date ' . $from . ' and ' . $to . ' can only be deleted'
                ));

                $payable->load(['currentOrder']);
                if ($currentOrder = $payable->currentOrder) {
                    $currentOrder->fill([
                        'invoice_received_amount' => $currentOrder->invoice_received_amount - $payable->invoice_amount
                    ])->save();
                }


                throw_if(!$payable->delete(), new Exception('Could not delete Supplier.'));

                event(new PayableDeleted($payable));

                $databaseManager->commit();
                return $this->sendSuccessResponse([], 'Supplier deleted successfully.');
            } catch(\Exception $exception) {
                $databaseManager->rollback();
                return $this->sendError('Could not delete Supplier.');
            }
        });
    }
}
