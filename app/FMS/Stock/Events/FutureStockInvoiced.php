<?php

namespace App\FMS\Stock\Events;

use App\FMS\Supplier\Models\Payable;
use App\FMS\TransactionJournal\ValueObjects\TransactionJournalType;
use Illuminate\Support\Collection;

class FutureStockInvoiced
{
    public $payable;
    public $supplier;
    public $site;
    public $currentStocks;

    public function __construct(
        Payable $payable,
        Collection $currentStocks
    ) {
        $this->payable = $payable->load('supplier.site');    
        $this->supplier = $payable->supplier;
        $this->site = $payable->supplier->site;
        $this->currentStocks = $currentStocks;
    }

    public function currentStocks()
    {
        return $this->currentStocks;
    }

    public function transactionJournal()
    {

    }

    public function updateTransactionJournalData()
    {
        return [
            // 'date' => 
        ];
    }

    public function tradeCreditorsId()
    {
        return $this->site->trade_creditors_id;
    }

    public function deliveryBailingId()
    {
        return $this->site->delivery_bailing_id;
    }

    public function gstOnCreditorsId()
    {
        return $this->site->gst_on_creditors_id;
    }

    public function levyAccountId()
    {
        return $this->supplier->levy_account;
    }

    public function goodsAmount()
    {
        return $this->payable->goods ?? 0;
    }

    public function deliveryAmount()
    {
        return $this->payable->freight ?? 0;
    }

    public function gstAmount()
    {
        return $this->payable->gst ?? 0;
    }

    public function levyAmount()
    {
        return $this->payable->levy ?? 0;
    }

    public function invoiceDate()
    {
        return $this->payable->invoice_date;
    }

    public function transactionJournalData($for)
    {
        $debitAccountId = '';
        $creditAccountId = '';
        $debitAmount = 0;
        $creditAmount = 0;

        switch($for) {
            case 'delivery':
                $debitAccountId = $this->deliveryBailingId();
                $creditAccountId = $this->tradeCreditorsId();
                $debitAmount = $this->deliveryAmount();
                $creditAmount = $this->deliveryAmount();
            break;
            case 'gst':
                $debitAccountId = $this->gstOnCreditorsId();
                $creditAccountId = $this->tradeCreditorsId();
                $debitAmount = $this->gstAmount();
                $creditAmount = $this->gstAmount();
            break;
            case 'levy':
                $debitAccountId = $this->levyAccountId();
                $creditAccountId = $this->tradeCreditorsId();
                $debitAmount = $this->levyAmount();
                $creditAmount = $this->levyAmount();
            break;
        }

        return [
            'transaction_type' => TransactionJournalType::PURCHASES,
            'debit_account_id' => $debitAccountId,
            'credit_account_id' => $creditAccountId,
            'site_id' => $this->site->id,
            'debit_amount' => $debitAmount,
            'credit_amount' => $creditAmount,
            'name' => $this->supplier->trading_name,
            'date' => $this->payable->invoice_date,
            'debit_operator' => '+',
            'credit_operator' => '+',
            'action' => 'future_stock_invoiced',
            'payable_id' => $this->payable->id,
            'supplier_id' => $this->payable->supplier_id
        ];
    }
}
