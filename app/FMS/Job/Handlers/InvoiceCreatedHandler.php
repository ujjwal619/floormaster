<?php

namespace App\FMS\Job\Handlers;

use App\FMS\Account\Manager as AccountManager;
use App\FMS\Job\Events\InvoiceCreated;
use App\FMS\CashBook\Manager as CashBookManager;
use App\FMS\TransactionJournal\Manager as TransactionJournalManager;

class InvoiceCreatedHandler
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

    public function handle(InvoiceCreated $invoiceCreated)
    {
        //create transaction journal
        $this->transactionJournalManager->create($invoiceCreated->transactionJournalData());

        //alter account amount
        if ($tradeDebtorId = $invoiceCreated->getSite()->trade_debtors_id) {
            $this->accountManager->alterAmount($tradeDebtorId, $invoiceCreated->invoiceAmount());
        }

        if ($salesCodeId = $invoiceCreated->salesCodeId()) {
            $this->accountManager->alterAmount($salesCodeId, $invoiceCreated->netInvoice());
        } 
        
        if ($gstBilledId = $invoiceCreated->getSite()->gst_billed_on_sales_id) {
            $this->accountManager->alterAmount($gstBilledId, $invoiceCreated->gstAmount());
        }    

        $this->transactionJournalManager->create($invoiceCreated->transactionJournalData(true));
    }
}
