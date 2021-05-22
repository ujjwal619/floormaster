<?php

namespace App\FMS\Stock\Handlers;

use App\Data\Entities\Models\Stock\CurrentStock;
use App\FMS\Account\Manager as AccountManager;
use App\FMS\Stock\Events\FutureStockInvoiced;
use App\FMS\Stock\Manager as StockManager;
use App\FMS\Stock\Models\Allocation;
use App\FMS\Stock\Models\AllocationDispatch;
use App\FMS\Supplier\Events\PayableCreated;
use App\FMS\TransactionJournal\Manager as TransactionJournalManager;
use Exception;

class FutureStockInvoicedHandler
{
    private $transactionJournalManager;
    private $accountManager;
    private $stockManager;

    public function __construct(
        TransactionJournalManager $transactionJournalManager,
        AccountManager $accountManager,
        StockManager $stockManager
    ) {
        $this->transactionJournalManager = $transactionJournalManager;  
        $this->accountManager = $accountManager;  
        $this->stockManager = $stockManager;  
    }

    public function handle(FutureStockInvoiced $futureStockInvoiced)
    {
        try {
            $currentStocks = $futureStockInvoiced->currentStocks();
        
            $currentStocks->map(function(CurrentStock $currentStock) use ($futureStockInvoiced) {
                $coaNotUpdatedAllocationDispatches = $currentStock->coaNotUpdatedAllocationDispatches;
                $currentStock->load(['futureStockReceiveGroup.transactionJournal', 'futureStock']);
                $transactionJournal = $currentStock->futureStockReceiveGroup->transactionJournal;
                $futureStockDetails = $currentStock->futureStock->toArray();
                $futureStockDetails['quantity'] = $currentStock->quantity;

                $goodsAmount = $this->stockManager->calculateFutureStockPrice($futureStockDetails, 'goods');

                $this->accountManager->alterAmount(
                    $transactionJournal->debit_account_id, 
                    $goodsAmount
                );

                $this->accountManager->alterAmount(
                    $transactionJournal->credit_account_id, 
                    $goodsAmount
                );

                $transactionJournal->fill([
                    'date' => $futureStockInvoiced->invoiceDate(),
                    'debit_amount' => $transactionJournal->debit_amount + $goodsAmount,
                    'credit_amount' => $transactionJournal->credit_amount + $goodsAmount,
                ])->save();


                $coaNotUpdatedAllocationDispatches->map(function(AllocationDispatch $allocationDispatch) {
                    $transactionJournal = $allocationDispatch->transactionJournal;
                    $currentStock = $allocationDispatch->currentStock;
                    $futureStock = $currentStock->futureStock;
                    if ($futureStock && $transactionJournal) {
                        $futureStockDetails = $futureStock->toArray();
                        $futureStockDetails['quantity'] = $allocationDispatch->amount;

                        $goodsAmount = $this->stockManager->calculateFutureStockPrice(
                            $futureStockDetails,
                            'goods'
                        );
                        
                        $transactionJournal->fill([
                            'debit_amount' => $transactionJournal->debit_amount + $goodsAmount,
                            'credit_amount' => $transactionJournal->credit_amount + $goodsAmount,
                            ])->save();
        
                        $this->accountManager->alterAmount(
                            $transactionJournal->debit_account_id, 
                            $goodsAmount
                        );
            
                        $this->accountManager->alterAmount(
                            $transactionJournal->credit_account_id, 
                            $goodsAmount,
                            '-'
                        );
                    }

                    $allocationDispatch->fill(['is_coa_updated' =>  true])->save();
                });
            });

            $tradeCreditorId = $futureStockInvoiced->tradeCreditorsId();

            if ($deliveryBailingId = $futureStockInvoiced->deliveryBailingId()) {
                $this->transactionJournalManager->create(
                    $futureStockInvoiced->transactionJournalData('delivery')
                );

                $this->accountManager->alterAmount(
                    $deliveryBailingId,     
                    $futureStockInvoiced->deliveryAmount()
                );

                $this->accountManager->alterAmount(
                    $tradeCreditorId, 
                    $futureStockInvoiced->deliveryAmount()
                );
            }

            if ($gstOnCreditorsId = $futureStockInvoiced->gstOnCreditorsId()) {
                $this->transactionJournalManager->create(
                    $futureStockInvoiced->transactionJournalData('gst')
                );

                $this->accountManager->alterAmount(
                    $gstOnCreditorsId, 
                    $futureStockInvoiced->gstAmount()
                );

                $this->accountManager->alterAmount(
                    $tradeCreditorId, 
                    $futureStockInvoiced->gstAmount()
                );
            }

            if ($levyAccountId = $futureStockInvoiced->levyAccountId()) {
                $this->transactionJournalManager->create(
                    $futureStockInvoiced->transactionJournalData('levy')
                );

                $this->accountManager->alterAmount(
                    $levyAccountId, 
                    $futureStockInvoiced->levyAmount()
                );

                $this->accountManager->alterAmount(
                    $tradeCreditorId, 
                    $futureStockInvoiced->levyAmount()
                );
            }
        } catch(\Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
        
}
