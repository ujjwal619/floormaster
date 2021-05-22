<?php

namespace App\FMS\Stock\Actions;

use App\Data\Entities\Models\Stock\FutureStock;
use App\FMS\CurrentOrder\Models\MarryInvoice;
use App\FMS\Stock\Events\FutureStockInvoiced;
use App\FMS\Stock\Manager as StockManager;
use App\FMS\Supplier\Manager as SupplierManager;
use App\StartUp\BaseClasses\Controller\AdminController;
use Exception;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\Request;

class CreateMarryInvoice extends AdminController
{
    public function __invoke(
        FutureStock $futureStock,
        Request $request, 
        DatabaseManager $databaseManager,
        StockManager $stockManager,
        SupplierManager $supplierManager
    ) {
        $request->validate([
            'future_stock_id' => 'numeric|required',
            'current_stock_id' => 'array|required',
            'current_order_id' => 'numeric|required',
            'site_id' => 'numeric|required',
            'invoice_number' => 'numeric|required',
            'invoice_date' => 'date|required',
            'quantity' => 'numeric|required',
            'invoice_total' => 'numeric|required',
        ]);
        $details = $request->all();
        $databaseManager->beginTransaction();
        try {
            throw_if(
                $futureStock->quantity - $futureStock->invoiced - $details['quantity'] < 0, 
                new \Exception('Nothing left to invoice')
            );

            $futureStock->load(['currentOrder', 'color.product.supplier.site', 'job']);
            $supplier = $futureStock->color->product->supplier;
            $currentOrder = $futureStock->currentOrder;
            $details['current_stock_id'] = collect($details['current_stock_id']);

            $currentStocks = $details['current_stock_id']->map(function ($currentStockId) use (
                $stockManager,
                $details
            ) {
                $currentStock = $stockManager->findCurrentStock($currentStockId);
                
                // if ($currentStock->is_invoiced === false) {
                // continue;
                // }

                $currentStock->fill([
                        'is_invoiced' => true,
                        'supplier_inv_no' => $details['invoice_number']
                    ])->save();
                    
                    return $currentStock;
                });
                
            $futureStock->fill(['invoiced' => $futureStock->invoiced + $details['quantity']])->save();

            $currentOrder->fill([
                'invoice_received_amount' => $currentOrder->invoice_received_amount + $details['invoice_total']
            ])->save();

            $futureStock->marryInvoices()->create($details);

            $delivery = array_get($details, 'delivery', 0);
            $gst = array_get($details, 'gst_credit', 0);
            $levy = array_get($details, 'levy_amount', 0);
            $goods = $details['invoice_total'] - $delivery - $gst;
            if ($supplier->levy_account) {
                $goods = $goods - $levy;
            }

            $detailsForSupplierPayable = [
                'invoice_date' => $details['invoice_date'],
                'invoice_amount' => $details['invoice_total'],
                'goods' => $goods,
                'freight' => $delivery,
                'levy' => $supplier->levy_account ? $levy : 0,
                'gst' => $gst,
                'date_delivered' => $currentOrder->last_date_received,
                'order_no' => $currentOrder->id,
                'job_id' => $futureStock->job_id,
                'supplier_reference' => $details['invoice_number'],
                'client' => $futureStock->job ? $futureStock->job->trading_name : '',
                'future_stock_id' => $futureStock->id,
                'quantity' => $details['quantity']
            ];

            throw_if(
                !$payable = $supplierManager->savePayable(
                    $supplier, 
                    $detailsForSupplierPayable, 
                    true
                ), 
                new Exception('payable not created')
            );

            event(new FutureStockInvoiced($payable, $currentStocks));

            $databaseManager->commit();

            return $this->sendSuccessResponse([], 'Successfully created marry invoice.');
        } catch (\Exception $exception) {
            $databaseManager->rollBack();
            
            dd($exception);
            return $this->sendError('Could not create marry invoice.');
        }
    }
}
