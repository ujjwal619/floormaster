<?php

namespace App\Data\Entities\Models\Product;

use App\Constants\DBTable;
use App\Data\Entities\Models\Stock\CurrentStock;
use App\Data\Entities\Models\Stock\FutureStock;
use App\FMS\Core\Interfaces\HasMorphAlias;
use App\FMS\Core\Interfaces\HasMorphInterface;
use App\FMS\Core\Traits\GetMorphAlias;
use App\FMS\Memo\Models\Relationships\HasMemoReference;
use App\FMS\Memo\Models\Relationships\MemoReferenceable;
use App\FMS\Stock\Models\Allocation;
use App\FMS\Stock\Models\AllocationDispatch;
use App\FMS\Stock\Models\BackOrder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VariantProduct
 * @package App\Data\Entities\Models\Product
 */
class ProductVariant extends Model implements MemoReferenceable, HasMorphAlias, HasMorphInterface
{
    use HasMemoReference, GetMorphAlias;
    
    const MORPH_ALIAS = 'color';
    /**
     * @var string
     */
    protected $table = DBTable::PRODUCT_VARIANTS;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'site_id',
        'reorder',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function productTypes()
    {
        return $this->morphTo();
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function stock()
    {
        return $this->hasOne(\App\Data\Entities\Models\Stock\Stock::class, 'variant_id');
    }

    public function currentStocks()
    {
        return $this->hasMany(CurrentStock::class, 'variant_id')->where('size', '>', 0);
    }

    public function futureStocks()
    {
        return $this->hasMany(FutureStock::class, 'variant_id')->where('is_archived', false);
    }

    public function allocations()
    {
        return $this->hasMany(Allocation::class, 'variant_id')->where('amount', '>', 0);
    }

    public function backOrders()
    {
        return $this->hasMany(BackOrder::class, 'variant_id')->where('amount', '>', 0);
    }

    public function allocationDispatches()
    {
        return $this->hasMany(AllocationDispatch::class, 'variant_id')->with(['job.site', 'allocation.currentStock']);
    }
}
