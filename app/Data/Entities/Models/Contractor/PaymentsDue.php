<?php

namespace App\Data\Entities\Models\Contractor;

use App\Constants\DBTable;
use App\Data\Entities\Models\Job\Job;
use App\FMS\Site\Models\Site;
use Illuminate\Database\Eloquent\Model;

class PaymentsDue extends Model
{
    protected $table = DBTable::CONTRACTOR_PAYMENT_DUE;

    protected $fillable = [
        'job_id',
        'details',
        'amount',
        'gst',
        'date',
        'invoice_no',
        'customer_id',
        'client',
        'project',
        'gst_amount',
        'site_id',
        'is_paid',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
