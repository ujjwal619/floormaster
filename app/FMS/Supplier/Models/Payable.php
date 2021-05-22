<?php

namespace App\FMS\Supplier\Models;

use App\Data\Entities\Models\Account\Account;
use App\Data\Entities\Models\Job\Job;
use App\Data\Entities\Models\Stock\CurrentOrder;
use App\Data\Entities\Models\Supplier\Supplier;
use App\FMS\Core\Traits\GetCreatedAtAttribute;
use App\FMS\Site\Models\Site;
use Illuminate\Database\Eloquent\Model;

class Payable extends Model
{
    use GetCreatedAtAttribute;

    protected $table = 'supplier_payables';

    protected $fillable = [
        'site_id',
        'liability_account',
        'cost_account',
        'levy_account',
        'job_id',
        'order_no',
        'supplier_reference',
        'client',
        'date_delivered',
        'invoice_date',
        'invoice_amount',
        'goods',
        'freight',
        'levy',
        'gst',
        'comments',
        'adjustment',
        'trading_terms',
        'credit_request',
        'expected_amount',
        'is_paid',
        'future_stock_id',
        'quantity',
    ];

    protected $casts = [
        'trading_terms' => 'object',
        'credit_request' => 'object'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function levyAccount()
    {
        return $this->belongsTo(Account::class, 'levy_account');
    }

    public function costAccount()
    {
        return $this->belongsTo(Account::class, 'cost_account');
    }

    public function liabilityAccount()
    {
        return $this->belongsTo(Account::class, 'liability_account');
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function currentOrder()
    {
        return $this->belongsTo(CurrentOrder::class, 'order_no');
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
