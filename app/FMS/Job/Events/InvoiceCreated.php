<?php

namespace App\FMS\Job\Events;

use App\Data\Entities\Models\Job\Invoice;
use App\Data\Entities\Models\Job\Job;
use App\FMS\TransactionJournal\ValueObjects\TransactionJournalType;

class InvoiceCreated
{
    public $invoice;
    public $job;
    public $site;

    public function __construct(Invoice $invoice, Job $job)
    {
        $this->invoice = $invoice;
        $this->job = $job;
        $this->site = $job->site;
    }

    public function getSite()
    {
        return $this->site;
    }

    public function invoiceAmount()
    {
        return $this->invoice->amount;
    }

    public function gstAmount()
    {
        return $this->invoice->gst_amount;
    }

    public function netInvoice()
    {
        return $this->invoice->net_invoice;
    }

    public function salesCodeId()
    {
        return $this->job->sales_code_id;
    }

    public function transactionJournalData($gstData = false)
    {
        return [
            'transaction_type' => TransactionJournalType::SALES,
            'debit_account_id' => $this->site->trade_debtors_id,
            'credit_account_id' => $gstData ? $this->site->gst_billed_on_sales_id : $this->salesCodeId(),
            'job_id' => $this->job->id,
            'site_id' => $this->job->site_id,
            'invoice_id' => $this->invoice->id,
            'debit_amount' => $gstData ? $this->gstAmount() : $this->netInvoice(),
            'credit_amount' => $gstData ? $this->gstAmount() : $this->netInvoice(),
            'name' => $this->job->trading_name,
            'date' => $this->invoice->date,
            'debit_operator' => '+',
            'credit_operator' => '+',
            'action' => 'job_invoice_created'
        ];
    }
}
