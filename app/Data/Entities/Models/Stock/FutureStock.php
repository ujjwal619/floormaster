<?php

namespace App\Data\Entities\Models\Stock;

use App\Constants\DBTable;
use App\Data\Entities\Models\Job\Job;
use App\Data\Entities\Models\Job\JobMaterialSale;
use App\Data\Entities\Models\Product\ProductVariant;
use App\FMS\CurrentOrder\Models\MarryInvoice;
use App\FMS\Stock\Models\BackOrder;
use App\FMS\Stock\Models\FutureStockReceiveGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FutureStock extends Model
{
    use SoftDeletes;

    protected $table = DBTable::FUTURE_STOCK;

    protected $fillable = [
        'quantity',
        'unit',
        'list_price',
        'discount',
        'delivery',
        'tax',
        'sell_price',
        'delivery_date',
        'placed_with',
        'order_number',
        'received',
        'sold',
        'invoiced',
        'levy',
        'total_cost',
        'site_id',
        'job_id',
        'job_material_id',
        'back_order_id',
        'product_name',
        'is_archived',
    ];

    public function color()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function orderReceipt()
    {
        return $this->hasMany(OrderReceipt::class, 'future_stock_id');
    }

    public function deliveryOrder()
    {
        //
    }

    public function backOrders()
    {
        return $this->hasMany(BackOrder::class, 'future_stock_id');
    }

    public function currentStocks()
    {
        return $this->hasMany(CurrentStock::class, 'future_stock_id')->where('is_invoiced', false);
    }

    public function marryInvoices()
    {
        return $this->hasMany(MarryInvoice::class, 'future_stock_id');
    }

    public function stock()
    {
        return $this->color->stock();
    }

    public function currentOrder()
    {
        return $this->belongsTo(CurrentOrder::class, 'order_number');
    }

    public function backOrder()
    {
        return $this->belongsTo(BackOrder::class, 'back_order_id');
    }

    public function jobMaterial()
    {
        return $this->belongsTo(JobMaterialSale::class, 'job_material_id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_material_id');
    }

    public function receiveGroups()
    {
        return $this->hasMany(FutureStockReceiveGroup::class, 'future_stock_id');
    }
//    public function getDeliveryDateAttribute($value)
//    {
//        return date('d M Y', strtotime($this->attributes['delivery_date']));
//    }

}
