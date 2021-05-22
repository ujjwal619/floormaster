<?php

namespace App\Data\Entities\Models\Product;

use App\Constants\DBTable;
use App\Data\Entities\Models\Quote\Quote;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Class LabourProduct
 * @package App\Data\Entities\Models\Product
 */
class LabourProduct extends Model
{
    /**
     * @var string
     */
    protected $table = DBTable::LABOUR_PRODUCTS;

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
     * Get all labour product's variants.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function productVariants()
    {
        return $this->morphMany(ProductVariant::class, 'product_type');
    }

    /**
     * Labour product belongs to many quotes.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function quotes()
    {
        return $this->belongsToMany(
            Quote::class,
            DBTable::PIVOT_QUOTES_LABOUR_SALES_PRICE,
            'labour_product_id',
            'quote_id'
        );
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
