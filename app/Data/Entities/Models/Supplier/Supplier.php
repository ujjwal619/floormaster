<?php

namespace App\Data\Entities\Models\Supplier;

use App\Constants\DBTable;
use App\Data\Entities\Accessors\Supplier\SupplierAccessor;
use App\Data\Entities\Models\Account\Account;
use App\Data\Entities\Models\JobSource\JobSource;
use App\Data\Entities\Models\Product\Product;
use App\Data\Entities\Models\User\User;
use App\Data\Entities\Traits\ModelTrait;
use App\FMS\Core\Traits\BelongsToSite;
use App\FMS\Remittance\Models\Remittance;
use App\FMS\Remittance\Models\RemittanceItem;
use App\FMS\Site\Models\Site;
use App\FMS\Supplier\Models\Payable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * Class Supplier
 * @property Collection jobSources
 * @property Collection salesStaffs
 * @property Collection sites
 * @package App\Data\Entities\Models
 */
class Supplier extends Model
{
    use ModelTrait, SoftDeletes, BelongsToSite;

    /**
     * Specify the table name.
     * @var string
     */
    protected $table = DBTable::SUPPLIERS;

    /**
     * Cast the following field to following types.
     * @var array
     */
    protected $casts = [
        'sales_detail' => 'object',
        'early_discount' => 'object',
        'normal_discount' => 'object',
        'bank' => 'object',
        'products' => 'object'
    ];

    /**
     * The following fields are fillable.
     * @var array
     */
    protected $fillable = [
        'trading_name',
        'street',
        'suburb',
        'state',
        'abn',
        'phone',
        'fax',
        'code',
        'contact',
        'key_no',
        'email',
        'product_list_url',
        'sales_detail',
        'early_discount',
        'normal_discount',
        'bank',
        'default_cost_account',
        'levy_account',
        'delivery',
        'central_billing',
        'site_id',
        'levy_percent',
        'products',
    ];

    /**
     * A supplier might have many job sources.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function jobSources()
    {
        return $this->belongsToMany(JobSource::class, DBTable::PIVOT_JOB_SOURCE_SUPPLIER);
    }

    /**
     * A supplier might have many sites.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sites()
    {
        return $this->hasMany(SupplierSite::class);
    }

    public function remittances()
    {
        return $this->hasMany(Remittance::class, 'supplier_id');
    }

    public function remittanceItems()
    {
        return $this
            ->hasManyThrough(
                RemittanceItem::class, 
                Remittance::class, 
                'supplier_id', 
                'remittance_id'
            )->where('remittance_items.is_paid', 1);
    }

    /**
     * A supplier might have many sales staff.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function salesStaffs()
    {
        return $this->belongsToMany(User::class, DBTable::PIVOT_SALES_STAFF_SUPPLIER, 'supplier_id', 'sales_id');
    }

    /**
     * Accessor for sales detail attribute
     *
     * @param $value
     *
     * @return \stdClass
     */
    public function getSalesDetailAttribute($value)
    {
        if (is_null($value) || $value === "null") {
            return new \stdClass();
        }

        return json_decode($value);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function supplierProducts()
    {
        return $this->hasMany(Product::class);
    }

    public function default_cost_account()
    {
        return $this->belongsTo(Account::class, 'default_cost_account');
    }

    public function levy_account()
    {
        return $this->belongsTo(Account::class, 'levy_account');
    }

    public function central_billing()
    {
        return $this->belongsTo(Supplier::class, 'central_billing');
    }

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }

    public function payables()
    {
        return $this->hasMany(Payable::class)->where('is_paid', false);
    }

    public function paid()
    {
        return $this->hasMany(Payable::class)->where('is_paid', true);
    }
}
