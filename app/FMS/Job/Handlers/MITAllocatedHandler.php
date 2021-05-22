<?php

namespace App\FMS\Job\Handlers;

use App\FMS\Account\Manager as AccountManager;
use App\FMS\CashBook\Manager as CashBookManager;
use App\FMS\Job\Events\MITAllocated;
use App\FMS\TransactionJournal\Manager as TransactionJournalManager;

class MITAllocatedHandler
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

    public function handle(MITAllocated $mitAllocated)
    {
        //create cash book
        // $this->cashBookManager->createCashBook($mitAllocated->cashBookData());

        //create transaction journal
        $this->transactionJournalManager->create($mitAllocated->transactionJournalData());

        //alter account amount
        if ($moneyInTrustId = $mitAllocated->getSite()->money_in_trust_id) {
            $this->accountManager->alterAmount($moneyInTrustId, $mitAllocated->receiptAmount(), '-');
        } 

        if ($tradeDebtorId = $mitAllocated->getSite()->trade_debtors_id) {
            $this->accountManager->alterAmount($tradeDebtorId, $mitAllocated->receiptAmount(), '-');
        }   
    }
}
