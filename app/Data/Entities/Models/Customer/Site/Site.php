<?php

namespace App\Data\Entities\Models\Customer\Site;

use App\Constants\DBTable;
use App\Data\Entities\Models\Customer\Customer;
use App\Data\Entities\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Site
 * @package App\Data\Entities\Models\Customer\Site
 */
class Site extends Model
{
    use SoftDeletes, ModelTrait;

    /**
     * The following fields are mass assignable.
     * @var array
     */
    protected $fillable = ['shop_name', 'gl_suffix'];

    /**
     * Specify the table name.
     * @var string
     */
    protected $table = DBTable::CUSTOMER_SITES;

    /**
     * Site belongs to the customer.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Customer::class);
    }
}
