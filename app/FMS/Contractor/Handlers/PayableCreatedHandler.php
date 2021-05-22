<?php

namespace App\FMS\Contractor\Handlers;

use App\FMS\Account\Manager as AccountManager;
use App\FMS\Contractor\Events\PayableCreated;
use App\FMS\TransactionJournal\Manager as TransactionJournalManager;

class PayableCreatedHandler
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

    public function handle(PayableCreated $payableCreated)
    {
        if ($cosAccount = $payableCreated->getContractor()->cost_of_sales_account) {
            $this->transactionJournalManager->create($payableCreated->transactionJournalData());
            $this->accountManager->alterAmount($cosAccount, $payableCreated->getPayable()->amount);
        }

        if ($liabilityAccount = $payableCreated->getContractor()->contractor_liability_account) {
            $this->accountManager->alterAmount($liabilityAccount, $payableCreated->getPayable()->amount);
            $this->accountManager->alterAmount($liabilityAccount, $payableCreated->getPayable()->gst_amount);
        }

        if ($gstOnCreditorsId = $payableCreated->getSite()->gst_on_creditors_id) {
            $this->transactionJournalManager->create($payableCreated->transactionJournalData('gst'));
            $this->accountManager->alterAmount($gstOnCreditorsId, $payableCreated->getPayable()->gst_amount);
        }
    }
}