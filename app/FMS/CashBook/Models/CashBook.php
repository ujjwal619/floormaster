<?php

namespace App\FMS\CashBook\Models;

use App\Data\Entities\Models\Account\Account;
use App\Data\Entities\Models\Job\Job;
use App\Data\Entities\Models\Job\Receipt;
use App\FMS\Remittance\Models\Remittance;
use App\FMS\Site\Models\Site;
use Illuminate\Database\Eloquent\Model;

class CashBook extends Model
{
    protected $table = 'cash_books';

    protected $fillable = [
        'type',
        'payee',
        'date',
        'presented_date',
        'net_amount',
        'gst_credit',
        'payment_type',
        'job_id',
        'site_id',
        'account_id',
        'remit_id',
        'receipt_id',
        'eft_cheque',
        'supplier_id'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function remittance()
    {
        return $this->belongsTo(Remittance::class, 'remit_id');
    }

    public function receipt()
    {
        return $this->belongsTo(Receipt::class, 'receipt_id');
    }

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }
}
