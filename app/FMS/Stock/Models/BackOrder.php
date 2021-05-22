<?php

namespace App\FMS\Stock\Models;

use App\Constants\DBTable;
use App\Data\Entities\Models\Job\Job;
use App\Data\Entities\Models\Job\JobMaterialSale;
use App\Data\Entities\Models\Product\ProductVariant;
use App\Data\Entities\Models\Stock\CurrentStock;
use App\Data\Entities\Models\Stock\FutureStock;
use App\Data\Entities\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class BackOrder extends Model
{
    use ModelTrait;

    protected $table = DBTable::STOCK_BACK_ORDERS;

    protected $fillable = [
        'variant_id',
        'client',
        'job_id',
        'future_stock_id',
        'date_required',
        'amount',
        'notes',
        'drop_off',
        'job_material_id',
        'site_id',
        'project',
        'placed',
        'is_linked'
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function jobMaterial()
    {
        return $this->belongsTo(JobMaterialSale::class, 'job_material_id');
    }

    public function futureStock()
    {
        return $this->belongsTo(FutureStock::class, 'future_stock_id');
    }

    public function color()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function stock()
    {
        return $this->color->stock;
    }
}
