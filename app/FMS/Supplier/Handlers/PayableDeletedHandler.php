<?php

namespace App\FMS\Supplier\Handlers;

use App\FMS\Account\Manager as AccountManager;
use App\FMS\Supplier\Events\PayableDeleted;
use App\FMS\TransactionJournal\Manager as TransactionJournalManager;

class PayableDeletedHandler
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

    public function handle(PayableDeleted $payableDeleted)
    {
        if ($goodsAccount = $payableDeleted->goodsAccountId()) {
            $this->transactionJournalManager->create($payableDeleted->transactionJournalData('goods'));
            $this->accountManager->alterAmount($goodsAccount, $payableDeleted->getPayable()->goods, '-');
        }

        if ($tradeCreditorId = $payableDeleted->getPayable()->liability_account) {
            $this->accountManager->alterAmount($tradeCreditorId, $payableDeleted->getPayable()->expected_amount, '-');
        }

        if ($deliveryBailingId = $payableDeleted->getSite()->delivery_bailing_id) {
            $this->transactionJournalManager->create($payableDeleted->transactionJournalData('delivery'));
            $this->accountManager->alterAmount($deliveryBailingId, $payableDeleted->getPayable()->freight, '-');
        }

        if ($gstOnCreditorsId = $payableDeleted->getSite()->gst_on_creditors_id) {
            $this->transactionJournalManager->create($payableDeleted->transactionJournalData('gst'));
            $this->accountManager->alterAmount($gstOnCreditorsId, $payableDeleted->getPayable()->gst, '-');
        }

        if ($levyAccountId = $payableDeleted->getPayable()->levy_account) {
            $this->transactionJournalManager->create($payableDeleted->transactionJournalData('levy'));
            $this->accountManager->alterAmount($levyAccountId, $payableDeleted->getPayable()->levy, '-');
        }

    }
}