<?php

namespace App\Data\Entities\Models\Stock;

use App\Constants\DBTable;
use App\Data\Entities\Models\Job\JobMaterialSale;
use App\FMS\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = DBTable::STOCKS;

    protected $fillable = [
        'notes',
        'future_stock_reorder',
        'total_current_stock',
        'total_future_stock',
        'current_stock_total_for_sell',
        'future_stock_total_for_sell',
        'total_allocations',
        'total_back_orders',
        'future_stock_reorder',
        'is_allocation_ongoing',
        'ongoing_allocation_causer',
        'ongoing_allocation_job_material_id'
    ];

    protected $casts = [
        'ongoing_allocation_data' => 'object'
    ];

    public function ongoingAllocationCauser()
    {
        return $this->belongsTo(User::class, 'ongoing_allocation_causer');
    }

    public function ongoingAllocationJobMaterialSale()
    {
        return $this->belongsTo(JobMaterialSale::class, 'ongoing_allocation_job_material_id');
    }
}
