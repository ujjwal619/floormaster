<?php

namespace App\FMS\Remittance\Events;

use App\FMS\CashBook\Models\CashBook;
use App\FMS\Remittance\Models\Remittance;
use App\FMS\Remittance\Models\RemittanceItem;
use App\FMS\Remittance\ValueObjects\PaymentType;
use App\FMS\TransactionJournal\ValueObjects\TransactionJournalType;

class PaidToSupplier
{
    private $remittance;
    private $supplier;
    private $site;
    private $cashBook;
    private $totalAmount;

    public function __construct(Remittance $remittance, CashBook $cashBook, float $totalAmount)
    {
        $this->remittance = $remittance;
        $this->supplier = $remittance->supplier;   
        $this->site = $this->remittance->site; 
        $this->cashBook  = $cashBook;
        $this->totalAmount  = $totalAmount;
    }

    public function getSite()
    {
        return $this->site;
    }

    public function expectedAmount()
    {
        return $this->totalAmount;
    }

    public function tradeCreditorAccount()
    {
        return $this->site->trade_creditors_id;
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
            'site_id' => $this->site->id,
            'remittance_id' => $this->remittance->id,
            'cash_book_id' => $this->cashBook->id,
            'debit_amount' => $this->expectedAmount(),
            'credit_amount' => $this->expectedAmount(),
            'name' => $this->remittance->payee ?? $this->supplier->trading_name,
            'date' => $this->remittance->transaction_date ?? $this->remittance->cheque_date,
            'eft_cheque' => $this->remittance->remittance_number,
            'debit_operator' => '-',
            'credit_operator' => '-',
            'action' => 'paid_to_supplier',
            'supplier_id' => $this->supplier->id
        ];
    }
}
