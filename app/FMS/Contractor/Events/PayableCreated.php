<?php

namespace App\FMS\Contractor\Events;

use App\Data\Entities\Models\Contractor\PaymentsDue;
use App\FMS\TransactionJournal\ValueObjects\TransactionJournalType;

class PayableCreated
{
    private $payable;
    private $contractor;
    private $site;

    public function __construct(PaymentsDue $payable)
    {
        $this->payable = $payable;    
        $this->contractor = $payable->contractor;
        $this->site = $payable->site;
    }

    public function getPayable()
    {
        return $this->payable;
    }

    public function getContractor()
    {
        return $this->contractor;
    }

    public function getSite()
    {
        return $this->site;
    }

    public function transactionJournalData($for = '')
    {
        $debitAccountId = '';
        $creditAccountId = '';
        $debitAmount = 0;
        $creditAmount = 0;

        switch($for) {
            case 'gst':
                $debitAccountId = $this->site->gst_on_creditors_id;
                $creditAccountId = $this->contractor->contractor_liability_account;
                $debitAmount = $this->payable->gst_amount;
                $creditAmount = $this->payable->gst_amount;
            break;
            default:
                $debitAccountId =  $this->contractor->cost_of_sales_account;
                $creditAccountId = $this->contractor->contractor_liability_account;
                $debitAmount = $this->payable->amount;
                $creditAmount = $this->payable->amount;
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
            'name' => $this->contractor->name,
            'date' => $this->payable->date,
            'debit_operator' => '+',
            'credit_operator' => '+',
            'action' => 'contractor_payable_created',
            'payable_id' => $this->payable->id,
            'contractor_id' => $this->contractor->id,
        ];
    }
}
