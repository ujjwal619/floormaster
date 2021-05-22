<?php

namespace App\FMS\Stock\Handlers;

use App\FMS\Account\Manager as AccountManager;
use App\FMS\Stock\Events\AllocationDispatched;
use App\FMS\Stock\Manager as StockManager;
use App\FMS\TransactionJournal\Manager as TransactionJournalManager;

class AllocationDispatchedHandler
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

    public function handle(AllocationDispatched $allocationDispatched)
    {
        $isInvoiced = $allocationDispatched->isInvoiced();
        $category = $allocationDispatched->getCategory();
        $allocation = $allocationDispatched->getAllocation();
        $allocationDispatch = $allocationDispatched->getAllocationDispatch();
        $transactionJournalId = $allocationDispatched->getTransactionJournalId();
        
        if ($isInvoiced) {
            $futureStockDetails = $allocationDispatched->futureStockData();
            $dispatchAmount = $this->stockManager->calculateFutureStockPrice($futureStockDetails, 'goods');
            
            if( $transactionJournalId) {
                $transactionJournal = $this->transactionJournalManager->findById($transactionJournalId);

                $transactionJournal->fill([
                    'date' => $allocationDispatched->getdate(),
                    'name' => $allocation->client,
                    'debit_amount' => $transactionJournal->debit_amount + $dispatchAmount,
                    'credit_amount' => $transactionJournal->credit_amount + $dispatchAmount,
                ])->save();
            } else {
                $transactionJournal = $this->transactionJournalManager->create(
                    $allocationDispatched->transactionJournalData($dispatchAmount)
                );
            }

            $this->accountManager->alterAmount($category->cos_account_id, $dispatchAmount);
            $this->accountManager->alterAmount($category->inventory_account_id, $dispatchAmount, '-');

            $allocationDispatch->fill([
                'transaction_journal_id' => $transactionJournal->id,
                'is_coa_updated' => true,
            ])->save();
        } else {
            if( $transactionJournalId) {
                $transactionJournal = $this->transactionJournalManager->findById($transactionJournalId);

                $transactionJournal->fill([
                    'date' => $allocationDispatched->getdate(),
                    'name' => $allocation->client,
                ])->save();
            } else {
                $transactionJournal = $this->transactionJournalManager->create(
                    $allocationDispatched->transactionJournalData()
                );
            }

            $allocationDispatch->fill([
                'transaction_journal_id' => $transactionJournal->id,
            ])->save();
        }
    }
}
