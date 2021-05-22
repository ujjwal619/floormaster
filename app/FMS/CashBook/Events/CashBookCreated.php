<?php

namespace App\FMS\CashBook\Events;

use App\Data\Entities\Models\Job\Job;
use App\Data\Entities\Models\Job\Receipt;
use App\FMS\CashBook\Models\CashBook;
use App\FMS\CashBookTypes;
use App\FMS\TransactionJournal\ValueObjects\TransactionJournalType;

class CashBookCreated
{
    public $cashBook;

    public function __construct(CashBook $cashBook)
    {
        $this->cashBook = $cashBook->load(['site']);
        $this->site = $cashBook->site;
    }

    public function netAmount()
    {
        return $this->cashBook->net_amount;
    }

    public function gstCredit()
    {
        return $this->cashBook->gst_credit;
    }

    public function totalAmount()
    {
        return $this->netAmount() + $this->gstCredit();
    }

    public function getSite()
    {
        return $this->site;
    }

    public function chequeAccountId()
    {
        return $this->getSite()->cheque_account_id;
    }

    public function cashBookAccountId()
    {
        return $this->cashBook->account_id;
    }

    public function gstOnCreditorsAccountId()
    {
        return $this->site->gst_on_creditors_id;
    }

    public function transactionJournalData($for = 'net')
    {
        return [
            'transaction_type' => TransactionJournalType::DISBURSEMENTS,
            'debit_account_id' => $for == 'net' ? $this->cashBookAccountId() : $this->gstOnCreditorsAccountId(),
            'credit_account_id' => $this->chequeAccountId(),
            'job_id' => $this->cashBook->job_id,
            'site_id' => $this->cashBook->site_id,
            'debit_amount' => $for == 'net' ? $this->netAmount() : $this->gstCredit(),
            'credit_amount' => $for == 'net' ? $this->netAmount() : $this->gstCredit(),
            'name' => $this->cashBook->payee,
            'date' => $this->cashBook->date,
            'payment_method' => $this->cashBook->payment_type,
            'debit_operator' => '+',
            'credit_operator' => '-',
            'action' => 'cash_book_created',
            'cash_book_id' => $this->cashBook->id
        ];
    }
}
