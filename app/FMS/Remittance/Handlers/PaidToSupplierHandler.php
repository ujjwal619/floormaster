<?php

namespace App\FMS\Remittance\Handlers;

use App\FMS\Account\Manager as AccountManager;
use App\FMS\CashBook\Manager as CashBookManager;
use App\FMS\Remittance\Events\PaidToSupplier;
use App\FMS\TransactionJournal\Manager as TransactionJournalManager;

class PaidToSupplierHandler
{
    private $transactionJournalManager;
    private $accountManager;
    private $cashBookManager;

    public function __construct(
        TransactionJournalManager $transactionJournalManager,
        AccountManager $accountManager,
        CashBookManager $cashBookManager
    ) {
        $this->transactionJournalManager = $transactionJournalManager;  
        $this->accountManager = $accountManager;  
        $this->cashBookManager = $cashBookManager;  
    }

    public function handle(PaidToSupplier $paidToSupplier)
    {
        $this->transactionJournalManager->create($paidToSupplier->transactionJournalData());

        //alter account amount
        if ($tradeCreditorId = $paidToSupplier->tradeCreditorAccount()) {
            $this->accountManager->alterAmount($tradeCreditorId, $paidToSupplier->expectedAmount(), '-');
        }

        if ($chequeAccountId = $paidToSupplier->chequeAccount()) {
            $this->accountManager->alterAmount($chequeAccountId, $paidToSupplier->expectedAmount(), '-');
        } 
    }
}
