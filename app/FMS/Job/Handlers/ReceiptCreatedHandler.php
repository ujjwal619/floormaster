<?php

namespace App\FMS\Job\Handlers;

use App\FMS\Account\Manager as AccountManager;
use App\FMS\Job\Events\ReceiptCreated;
use App\FMS\CashBook\Manager as CashBookManager;
use App\FMS\TransactionJournal\Manager as TransactionJournalManager;

class ReceiptCreatedHandler
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

    public function handle(ReceiptCreated $receiptCreated)
    {
        //create cash book
        $this->cashBookManager->createCashBook($receiptCreated->cashBookData());

        //create transaction journal
        $this->transactionJournalManager->create($receiptCreated->transactionJournalData());

        //alter account amount
        if ($chequeAccountId = $receiptCreated->getSite()->cheque_account_id) {
            $this->accountManager->alterAmount($chequeAccountId, $receiptCreated->receiptAmount());
        }
        
        if ($receiptCreated->isNonAllocatedMit()) {
            if ($moneyInTrustId = $receiptCreated->getSite()->money_in_trust_id) {
                $this->accountManager->alterAmount($moneyInTrustId, $receiptCreated->receiptAmount());
            }   
        } else {
            if ($tradeDebtorId = $receiptCreated->getSite()->trade_debtors_id) {
                $this->accountManager->alterAmount($tradeDebtorId, $receiptCreated->receiptAmount(), '-');
            }
        }
    }
}
