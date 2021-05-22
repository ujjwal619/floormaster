<?php

namespace App\FMS\Supplier\Handlers;

use App\FMS\Account\Manager as AccountManager;
use App\FMS\Supplier\Events\PayableCreated;
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
        if ($goodsAccount = $payableCreated->goodsAccountId()) {
            $this->transactionJournalManager->create($payableCreated->transactionJournalData('goods'));
            $this->accountManager->alterAmount($goodsAccount, $payableCreated->getPayable()->goods);
        }

        if ($tradeCreditorId = $payableCreated->getPayable()->liability_account) {
            $this->accountManager->alterAmount($tradeCreditorId, $payableCreated->getPayable()->expected_amount);
        }

        if ($deliveryBailingId = $payableCreated->getSite()->delivery_bailing_id) {
            $this->transactionJournalManager->create($payableCreated->transactionJournalData('delivery'));
            $this->accountManager->alterAmount($deliveryBailingId, $payableCreated->getPayable()->freight ?? 0);
        }

        if ($gstOnCreditorsId = $payableCreated->getSite()->gst_on_creditors_id) {
            $this->transactionJournalManager->create($payableCreated->transactionJournalData('gst'));
            $this->accountManager->alterAmount($gstOnCreditorsId, $payableCreated->getPayable()->gst ?? 0);
        }

        if ($levyAccountId = $payableCreated->getPayable()->levy_account) {
            $this->transactionJournalManager->create($payableCreated->transactionJournalData('levy'));
            $this->accountManager->alterAmount($levyAccountId, $payableCreated->getPayable()->levy ?? 0);
        }

    }
}