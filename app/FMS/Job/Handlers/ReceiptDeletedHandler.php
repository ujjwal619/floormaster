<?php

namespace App\FMS\Job\Handlers;

use App\FMS\Account\Manager as AccountManager;
use App\FMS\Job\Events\ReceiptDeleted;
use App\FMS\CashBook\Manager as CashBookManager;
use App\FMS\TransactionJournal\Manager as TransactionJournalManager;

class ReceiptDeletedHandler
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

    public function handle(ReceiptDeleted $receiptDeleted)
    {
        $receipt = $receiptDeleted->receipt();
        //delete cash book
        $receipt->cashBook()->delete();

        //create transaction journal
        $this->transactionJournalManager->create($receiptDeleted->transactionJournalData());

        //alter account amount
        if ($chequeAccountId = $receiptDeleted->getSite()->cheque_account_id) {
            $this->accountManager->alterAmount($chequeAccountId, $receiptDeleted->receiptAmount(), '-');
        }
        
        if ($receiptDeleted->isNonAllocatedMit()) {
            if ($moneyInTrustId = $receiptDeleted->getSite()->money_in_trust_id) {
                $this->accountManager->alterAmount($moneyInTrustId, $receiptDeleted->receiptAmount(), '-');
            }   
        } else {
            if ($tradeDebtorId = $receiptDeleted->getSite()->trade_debtors_id) {
                $this->accountManager->alterAmount($tradeDebtorId, $receiptDeleted->receiptAmount());
            }
        }
    }
}
