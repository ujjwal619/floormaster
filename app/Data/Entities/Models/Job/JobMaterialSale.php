<?php

namespace App\Data\Entities\Models\Job;

use App\Constants\DBTable;
use App\Data\Entities\Models\Product\MaterialProduct;
use App\Data\Entities\Models\Product\Product;
use App\Data\Entities\Models\Product\ProductVariant;
use App\Data\Entities\Models\Supplier\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class QuoteMaterialSale
 * @package App\Data\Entities\Models\Job
 */
class JobMaterialSale extends Model
{
    /**
     * @var string
     */

    protected $table = DBTable::PIVOT_JOBS_MATERIAL_SALES_PRICE;

    protected $fillable = [
        'supplier_id',
        'product_id',
        'variant_id', 
        'total', 
        'quantity', 
        'unit',
        'gst',
        'levy',
        'discount',
        'unit_sell',
        'allocated', 
        'on_order', 
        'dispatched', 
        'act_on'
    ];

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
