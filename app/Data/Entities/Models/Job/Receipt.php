<?php

namespace App\Data\Entities\Models\Job;

use App\Constants\DBTable;
use App\FMS\CashBook\Models\CashBook;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $table = DBTable::JOB_RECEIPT;

    protected $fillable = [
        'receipt_date',
        'amount',
        'notation',
        'payment_method',
        'invoice_id',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function cashBook()
    {
        return $this->hasOne(CashBook::class, 'receipt_id');
    }
}
