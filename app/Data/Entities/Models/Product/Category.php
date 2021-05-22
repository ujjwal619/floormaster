<?php

namespace App\Data\Entities\Models\Product;

use App\Data\Entities\Models\Account\Account;
use App\FMS\Core\Traits\BelongsToSite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Data\Entities\Traits\ModelTrait;
use App\Constants\DBTable;

/**
 * Category Model.
 * @package App\Data\Entities\Product\Category
 */
class Category extends Model
{
    use ModelTrait, SoftDeletes, BelongsToSite;

    /**
     * Specify the table name.
     *
     * @var string
     */
    protected $table = DBTable::PRODUCT_CATEGORIES;

    /**
     * The following fields are fillable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'title', 
        'description', 
        'site_id', 
        'inventory_account_id', 
        'cos_account_id'
    ];

    public function inventoryAccount()
    {
        return $this->belongsTo(Account::class, 'inventory_account_id');
    }

    public function cosAccount()
    {
        return $this->belongsTo(Account::class, 'cos_account_id');
    }
}
