<?php

namespace App\FMS\CashBook\Handlers;

use App\FMS\Account\Manager as AccountManager;
use App\FMS\CashBook\Events\CashBookCreated;
use App\FMS\Job\Events\ReceiptCreated;
use App\FMS\CashBook\Manager as CashBookManager;
use App\FMS\TransactionJournal\Manager as TransactionJournalManager;

class CashBookCreatedHandler
{
    public $cashBookManager;
    public $transactionJournalManager;
    public $accountManager;

    public function __construct(
        CashBookManager $cashBookManager,
        TransactionJournalManager $transactionJournalManager,
        AccountManager $accountManager
    ) {
        $this->cashBookManager = $cashBookManager;  
        $this->transactionJournalManager = $transactionJournalManager;  
        $this->accountManager = $accountManager;  
    }

    public function handle(CashBookCreated $cashBookCreated)
    {
        //create transaction journal
        $this->transactionJournalManager->create($cashBookCreated->transactionJournalData());
        $this->transactionJournalManager->create($cashBookCreated->transactionJournalData('gst'));

        //alter account amount
        if ($chequeAccountId = $cashBookCreated->chequeAccountId()) {
            $this->accountManager->alterAmount(
                $chequeAccountId, 
                $cashBookCreated->totalAmount(),
                '-'
            );
        }
        
        if ($cashBookAccountId = $cashBookCreated->cashBookAccountId()) {
            $this->accountManager->alterAmount(
                $cashBookAccountId,
                $cashBookCreated->netAmount()
            );
        }

        if ($gstOnCreditorsAccountId = $cashBookCreated->gstOnCreditorsAccountId()) {
            $this->accountManager->alterAmount(
                $gstOnCreditorsAccountId,
                $cashBookCreated->gstCredit()
            );
        }
    }
}
