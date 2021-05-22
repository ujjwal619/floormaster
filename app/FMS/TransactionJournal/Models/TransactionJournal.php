<?php

namespace App\FMS\TransactionJournal\Models;

use App\Constants\DBTable;
use App\Data\Entities\Models\Account\Account;
use App\Data\Entities\Models\Job\Job;
use Illuminate\Database\Eloquent\Model;

class TransactionJournal extends Model
{
    protected $table = DBTable::TRANSACTION_JOURNAL;

    protected $fillable = [
        'transaction_type',
        'payment_method',
        'site_id',
        'debit_account_id',
        'credit_account_id',
        'job_id',
        'invoice_id',
        'cash_book_id',
        'contractor_id',
        'remittance_id',
        'debit_amount',
        'credit_amount',
        'name',
        'note',
        'date',
        'eft_cheque',
        'future_stock_receive_group_id',
        'debit_operator',
        'credit_operator',
        'supplier_id',
        'payable_id',
        'receipt_id',
        'allocation_id',
    ];

    public function debitAccount()
    {
        return $this->belongsTo(Account::class, 'debit_account_id');
    }

    public function creditAccount()
    {
        return $this->belongsTo(Account::class, 'credit_account_id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }
}
