<?php

namespace App\Data\Entities\Models\Product;

use App\Constants\DBTable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Stock
 * @package App\Data\Entities\Models\Product
 */
class Stock extends Model
{
    protected $guarded = [];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = DBTable::STOCKS;

    /**
     * Get all of the owning reference models.
     */
    public function products()
    {
        return $this->morphTo('product', 'product_type', 'product_id');
    }
}
