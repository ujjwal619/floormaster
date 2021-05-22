<?php

namespace App\FMS\Stock\Models;

use App\Constants\DBTable;
use App\Data\Entities\Models\Job\Job;
use App\Data\Entities\Models\Job\JobMaterialSale;
use App\Data\Entities\Models\Product\ProductVariant;
use App\Data\Entities\Models\Stock\CurrentStock;
use App\Data\Entities\Traits\ModelTrait;
use App\FMS\Core\Traits\GetCreatedAtAttribute;
use App\FMS\TransactionJournal\Models\TransactionJournal;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Allocation extends Model
{
    use ModelTrait, GetCreatedAtAttribute;

    protected $table = DBTable::STOCK_ALLOCATIONS;

//    protected $with = ['stock'];

    protected $fillable = [
        'variant_id',
        'client',
        'job_id',
        'current_stock_id',
        'date_required',
        'amount',
        'notes',
        'drop_off',
        'job_material_id',
        'site_id',
        'project',
        'is_linked',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function currentStock()
    {
        return $this->belongsTo(CurrentStock::class, 'current_stock_id');
    }

    public function color()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function jobMaterial()
    {
        return $this->belongsTo(JobMaterialSale::class, 'job_material_id');
    }

    public function dispatches()
    {
        return $this->hasMany(AllocationDispatch::class, 'allocation_id');
    }
}
