<?php

namespace App\FMS\Remittance\Handlers;

use App\FMS\Account\Manager as AccountManager;
use App\FMS\Remittance\Events\PaidToContractor;
use App\FMS\TransactionJournal\Manager as TransactionJournalManager;

class PaidToContractorHandler
{
    private $transactionJournalManager;
    private $accountManager;

    public function __construct(
        TransactionJournalManager $transactionJournalManager,
        AccountManager $accountManager
    ) {
        $this->transactionJournalManager = $transactionJournalManager;  
        $this->accountManager = $accountManager;  
    }

    public function handle(PaidToContractor $paidToContractor)
    {
        $this->transactionJournalManager->create($paidToContractor->transactionJournalData());

        //alter account amount
        if ($tradeCreditorId = $paidToContractor->tradeCreditorAccount()) {
            $this->accountManager->alterAmount($tradeCreditorId, $paidToContractor->getTotalAmount(), '-');
        }

        if ($chequeAccountId = $paidToContractor->chequeAccount()) {
            $this->accountManager->alterAmount($chequeAccountId, $paidToContractor->getTotalAmount(), '-');
        } 
    }
}
