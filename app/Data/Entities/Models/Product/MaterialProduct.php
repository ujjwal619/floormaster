<?php

namespace App\Data\Entities\Models\Product;

use App\Constants\DBTable;
use App\Data\Entities\Models\Quote\Quote;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Class MaterialProduct
 * @package App\Data\Entities\Models\Product
 */
class MaterialProduct extends Model
{
    /**
     * @var string
     */
    protected $table = DBTable::MATERIAL_PRODUCTS;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'unit_cost',
        'category_id',
        'metadata',
        'is_featured'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'meta_data' => 'object',
    ];

    /**
     * Get all material product's variants.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function productVariants()
    {
        return $this->morphMany(ProductVariant::class, 'product_type');
    }

    /**
     * Sales user belongs to many quotes.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function quotes()
    {
        return $this->belongsToMany(Quote::class, DBTable::PIVOT_QUOTES_MATERIAL_SALES_PRICE, 'product_id', 'quote_id');
    }

    /**
     * Labour product has many stocks.
     * @return MorphMany
     */
    public function stocks(): MorphMany
    {
        return $this->morphMany(Stock::class, 'product');
    }
}
