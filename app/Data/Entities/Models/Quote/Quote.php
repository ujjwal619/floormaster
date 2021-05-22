<?php

namespace App\Data\Entities\Models\Quote;

use App\Constants\DBTable;
use App\Data\Entities\Models\Account\Account;
use App\Data\Entities\Models\Customer\Customer;
use App\Data\Entities\Models\Job\Job;
use App\Data\Entities\Models\Memo\Memo;
use App\Data\Entities\Models\Product\LabourProduct;
use App\Data\Entities\Models\Product\MaterialProduct;
use App\Data\Entities\Models\Product\Product;
use App\Data\Entities\Models\User\User;
use App\Data\Entities\Traits\ModelTrait;
use App\FMS\Core\Interfaces\HasMorphAlias;
use App\FMS\Core\Traits\BelongsToSite;
use App\FMS\Core\Traits\GetMorphAlias;
use App\FMS\Memo\Models\Relationships\HasMemoReference;
use App\FMS\Memo\Models\Relationships\MemoReferenceable;
use App\FMS\Quote\Models\QuoteMaterial;
use App\FMS\SalesStaff\Models\SalesStaff;
use App\FMS\Shop\Models\Shop;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

/**
 * Class Quote
 * @property Customer   customer
 * @property User       sales
 * @property Collection materialSalesPrice
 * @property Collection labourSalesPrice
 * @property Job        job
 * @property int        id
 * @package App\Data\Entities\Models\Quote
 */
class Quote extends Model implements MemoReferenceable, HasMorphAlias
{
    use ModelTrait, BelongsToSite, HasMemoReference, GetMorphAlias;

    const MORPH_ALIAS = 'quote';

    /**
     * Specify the table name.
     * @var string
     */
    protected $table = DBTable::QUOTES;

    /**
     * The following fields are mass assignable.
     * @var array
     */
    protected $fillable = [
        'project',
        'remarks',
        'metadata',
        'quote_id',
        'terms',
        'job_source_id',
        'customer_id',
        'commission',
        'labour',
        'site_id',
        'converted_to_job',
        'calculated_total_sell',
        'gst',
        'gst_inclusive_quote',
        'type',
        'term',
        'sales_code_id',
        'title',
        'firstname',
        'trading_name',
        'address',
        'contact',
        'sales_code_id',
        'phone',
        'work_phone',
        'mobile',
        'email',
        'fax',
        'material_total',
        'labour_total',
        'net_cost',
        'costed_commission',
        'quote_price',
        'gst_amount',
        'margin',
        'markup',
        'gp',
        'quote_date',
        'shop_id'
    ];

    /**
     * Cast the following fields to following data types.
     * @var array
     */
    protected $casts = [
        'metadata'   => 'object',
        'commission' => 'object',
        'labour' =>'object',
        'term' =>'object',
        'address'       => 'object'
    ];

    /**
     * One quote has one customer.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Quote has many sales.
     */
    public function sales(): BelongsToMany
    {
        return $this->belongsToMany(SalesStaff::class, DBTable::PIVOT_QUOTES_SALES, 'quote_id', 'sales_id')->withPivot('priority', 'commission');
    }

    /**
     * Quote belongs to many material sales price.
     */
    public function materialSalesPrice(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, DBTable::PIVOT_QUOTES_MATERIAL_SALES_PRICE, 'quote_id', 'product_id')->withPivot('variant_id', 'quantity', 'unit', 'total');
    }

    /**
     * @return BelongsToMany
     */
    public function primarySalesPerson(): BelongsToMany
    {
        return $this->belongsToMany(User::class, DBTable::PIVOT_QUOTES_SALES, 'job_id',
            'sales_id')->withPivot('priority', 'commission')->where('priority', 'primary');
    }

    /**
     * Quote belongs to many labour sales price.
     */
    public function labourSalesPrice(): BelongsToMany
    {
        return $this->belongsToMany(LabourProduct::class, DBTable::PIVOT_QUOTES_LABOUR_SALES_PRICE, 'quote_id', 'labour_product_id')->withPivot('quantity', 'unit', 'total');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function materials(): HasMany
    {
        return $this->hasMany(QuoteMaterialSale::class, 'quote_id');
    }

    /**
     * One quote has one job.
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function job(): HasOne
    {
        return $this->hasOne(Job::class);
    }

    /**
     * One quote has many memos.
     */
    public function memos()
    {
        return $this->morphMany(Memo::class, 'reference', 'reference_type', 'reference_id');
    }

    public function salesCode()
    {
        return $this->belongsTo(Account::class, 'sales_code_id');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
