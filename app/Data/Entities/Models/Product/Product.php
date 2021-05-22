<?php

namespace App\Data\Entities\Models\Product;

use App\Constants\DBTable;
use App\Data\Entities\Models\Product\Category;
use App\Data\Entities\Models\Stock\CurrentStock;
use App\Data\Entities\Models\Stock\FutureStock;
use App\Data\Entities\Models\Supplier\Supplier;
use App\FMS\Site\Models\Site;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = DBTable::PRODUCTS;

    protected $fillable = [
        'name',
        'alias',
        'price_base',
        'category_id',
        'list_cost',
        'upc',
        'discount',
        'levy',
        'net_cost',
        'gst',
        'width',
        'unit',
        'trade_sell',
        'retail_sell',
        'installed',
        'act_on_me',
        'non_product',
        'exclude_from_report',
        'site_id',
        'supplier_id'
    ];

    protected $casts = [
        'retail_sell' => 'array',
        'trade_sell' => 'array',
        'installed' => 'array',
    ];

    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
