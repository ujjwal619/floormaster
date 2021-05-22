<?php

namespace App\FMS\Job\Events;

use App\Data\Entities\Models\Job\Job;
use App\Data\Entities\Models\Job\Receipt;
use App\FMS\CashBookTypes;
use App\FMS\TransactionJournal\ValueObjects\TransactionJournalType;

class ReceiptDeleted
{
    public $receipt;
    public $job;
    public $site;

    public function __construct(Receipt $receipt, Job $job)
    {
        $this->receipt = $receipt;
        $this->job = $job;
        $this->site = $job->site;
    }

    public function receipt()
    {
        return $this->receipt;
    }

    public function isNonAllocatedMit()
    {
        return !$this->receipt->invoice_id;
    }

    public function receiptAmount()
    {
        return $this->receipt->amount;
    }

    public function cashBookData()
    {
        return [
            'receipt_id' => $this->receipt->id,
            'payee' => $this->job->trading_name,
            'type' => CashBookTypes::CREDIT,
            'date' => $this->receipt->receipt_date,
            'net_amount' => $this->receipt->amount,
            'payment_method' =>  $this->receipt->payment_method,
            'site_id' => $this->job->site_id,
        ];
    }

    public function getSite()
    {
        return $this->site;
    }

    public function transactionJournalData()
    {
        return [
            'transaction_type' => TransactionJournalType::RECEIPTS,
            'debit_account_id' => $this->site->cheque_account_id,
            'credit_account_id' => $this->isNonAllocatedMit() ? $this->site->money_in_trust_id : $this->site->trade_debtors_id,
            'job_id' => $this->job->id,
            'site_id' => $this->job->site_id,
            'invoice_id' => $this->receipt->invoice_id,
            'receipt_id' => $this->receipt->id,
            'debit_amount' => -$this->receipt->amount,
            'credit_amount' => -$this->receipt->amount,
            'name' => $this->job->trading_name,
            'date' => $this->receipt->receipt_date,
            'payment_method' => $this->receipt->payment_method,
            'debit_operator' => '-',
            'credit_operator' => $this->isNonAllocatedMit() ? '-' : '+',
            'action' => 'invoice_receipt_deleted'
        ];
    }
}
