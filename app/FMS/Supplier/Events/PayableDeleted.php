<?php

namespace App\FMS\Supplier\Events;

use App\FMS\Supplier\Models\Payable;
use App\FMS\TransactionJournal\ValueObjects\TransactionJournalType;

class PayableDeleted
{
    private $payable;
    private $supplier;
    private $site;

    public function __construct(Payable $payable)
    {
        $this->payable = $payable->load(['supplier', 'site']);    
        $this->supplier = $payable->supplier;
        $this->site = $payable->site;
    }

    public function getPayable()
    {
        return $this->payable;
    }

    public function getSite()
    {
        return $this->site;
    }

    public function goodsAccountId()
    {
        return $this->payable->cost_account;
    }

    public function transactionJournalData($for)
    {
        $debitAccountId = '';
        $creditAccountId = '';
        $debitAmount = 0;
        $creditAmount = 0;

        switch($for) {
            case 'goods':
                $debitAccountId =  $this->goodsAccountId();
                $creditAccountId = $this->payable->liability_account;
                $debitAmount = -$this->payable->goods;
                $creditAmount = -$this->payable->goods;
            break;
            case 'delivery':
                $debitAccountId = $this->site->delivery_bailing_id;
                $creditAccountId = $this->payable->liability_account;
                $debitAmount = -$this->payable->freight;
                $creditAmount = -$this->payable->freight;
            break;
            case 'gst':
                $debitAccountId = $this->site->gst_on_creditors_id;
                $creditAccountId = $this->payable->liability_account;
                $debitAmount = -$this->payable->gst;
                $creditAmount = -$this->payable->gst;
            break;
            case 'levy':
                $debitAccountId = $this->payable->levy_account;
                $creditAccountId = $this->payable->liability_account;
                $debitAmount = -$this->payable->levy;
                $creditAmount = -$this->payable->levy;
            break;
        }

        return [
            'transaction_type' => TransactionJournalType::PURCHASES,
            'debit_account_id' => $debitAccountId,
            'credit_account_id' => $creditAccountId,
            'job_id' => $this->payable->job_id,
            'site_id' => $this->payable->site_id,
            'debit_amount' => $debitAmount,
            'credit_amount' => $creditAmount,
            'name' => $this->supplier->trading_name,
            'date' => $this->payable->invoice_date,
            'debit_operator' => '-',
            'credit_operator' => '-',
            'action' => 'supplier_payable_deleted',
            'supplier_id' => $this->supplier->id,
            'payable_id' => $this->payable->id
        ];
    }
}
