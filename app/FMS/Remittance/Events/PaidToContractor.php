<?php

namespace App\FMS\Remittance\Events;

use App\FMS\CashBook\Models\CashBook;
use App\FMS\Remittance\Models\Remittance;
use App\FMS\Remittance\Models\RemittanceItem;
use App\FMS\Remittance\ValueObjects\PaymentType;
use App\FMS\TransactionJournal\ValueObjects\TransactionJournalType;

class PaidToContractor
{
    private $remittance;
    private $contractor;
    private $site;
    private $totalAmount;
    private $cashBook;

    public function __construct(Remittance $remittance, CashBook $cashBook, float $totalAmount)
    {
        $this->remittance = $remittance;    
        $this->contractor = $remittance->contractor;
        $this->site = $this->contractor->site;
        $this->totalAmount = $totalAmount;
        $this->cashBook = $cashBook;
    }

    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    public function tradeCreditorAccount()
    {
        return $this->contractor->contractor_liability_account;
    }

    public function chequeAccount()
    {
        return $this->site->cheque_account_id;
    }

    public function transactionJournalData()
    {
        return [
            'transaction_type' => TransactionJournalType::DISBURSEMENTS,
            'debit_account_id' => $this->tradeCreditorAccount(),
            'credit_account_id' => $this->chequeAccount(),
            'cash_book_id' => $this->cashBook->id,
            'site_id' => $this->site->id,
            'remittance_id' => $this->remittance->id,
            'debit_amount' => $this->totalAmount,
            'credit_amount' => $this->totalAmount,
            'name' => $this->contractor->name,
            'date' => $this->remittance->transaction_date ?? $this->remittance->cheque_date,
            'eft_cheque' => $this->remittance->remittance_number,
            'contractor_id' => $this->contractor->id,
            'debit_operator' => '-',
            'credit_operator' => '-',
            'action' => 'paid_to_contractor'
        ];
    }
}
