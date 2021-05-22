<?php

namespace App\Data\Entities\Models\Stock;

use App\Constants\DBTable;
use App\Data\Entities\Models\Job\Job;
use App\Data\Entities\Models\Supplier\Supplier;
use App\FMS\Site\Models\Site;
use Illuminate\Database\Eloquent\Model;

class CurrentOrder extends Model
{
    protected $table = DBTable::CURRENT_ORDER;

    protected $fillable = [
        'supplier_details',
        'delivery_address',
        'interim_order_number',
        'order_date',
        'supplier_reference',
        'costed_price',
        'invoice_received_amount',
        'due_date',
        'last_date_received',
        'site_id',
        'is_archived',
        'job_id',
        'sales_rep',
        'client_name',
        'sales_contact',
        'supplier_id',
        'supplier_name',
        'is_general'
    ];

    protected $casts = [
        'supplier_details' => 'array',
        'delivery_address' => 'array',
    ];

    public function futureStocks()
    {
        return $this->hasMany(FutureStock::class, 'order_number');
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
