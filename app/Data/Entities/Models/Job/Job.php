<?php

namespace App\Data\Entities\Models\Job;


use App\Constants\DBTable;
use App\Data\Entities\Models\Account\Account;
use App\Data\Entities\Models\Contractor\PaymentsDue;
use App\Data\Entities\Models\Customer\Customer;
use App\Data\Entities\Models\Memo\Memo;
use App\Data\Entities\Models\Product\LabourProduct;
use App\Data\Entities\Models\Product\Product;
use App\Data\Entities\Models\Quote\Quote;
use App\Data\Entities\Models\Stock\FutureStock;
use App\Data\Entities\Traits\ModelTrait;
use App\FMS\Core\Interfaces\HasMorphAlias;
use App\FMS\Core\Traits\BelongsToSite;
use App\FMS\Core\Traits\GetMorphAlias;
use App\FMS\Invoice\Model\Expense;
use App\FMS\Memo\Models\Relationships\HasMemoReference;
use App\FMS\Memo\Models\Relationships\MemoReferenceable;
use App\FMS\Remittance\Models\RemittanceItem;
use App\FMS\SalesStaff\Models\SalesStaff;
use App\FMS\Shop\Models\Shop;
use App\FMS\Stock\Models\Allocation;
use App\FMS\Stock\Models\AllocationDispatch;
use App\FMS\Stock\Models\BackOrder;
use App\FMS\Supplier\Models\Payable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Job
 * @property int id
 * @package App\Data\Entities\Models\Job
 */
class Job extends Model implements MemoReferenceable, HasMorphAlias
{
    use ModelTrait, BelongsToSite, HasMemoReference, GetMorphAlias;

    const MORPH_ALIAS = 'job';

    /**
     * Specify the table name.
     * @var string
     */

    protected $table = DBTable::JOBS;

    /**
     * The following fields are mass assignable.
     * @var array
     */
    protected $fillable = [
        'site_id',
        'project',
        'remarks',
        'metadata',
        'quote_id',
        'terms',
        'job_source_id',
        'customer_id',
        'job_id',
        'commission',
        'initiation_date',
        'invoice',
        'labour',
        'recently_converted',
        'calculated_total_sell',
        'gst',
        'gst_inclusive_quote',
        'type',
        'term',
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
        'unbilled_retention_amount',
        'unbilled_retention_release_date',
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
        'costed_commission_paid',
        'costed_commission_date_paid',
        'costed_commission_balance',
        'costed_commission_text',
        'completed_percent',
        'completed_on',
        'financed',
        'approved_date',
        'approval_code',
        'invoiced',
        'balance',
        'shop_id'
    ];

    /**
     * Cast the following fields to following data types.
     * @var array
     */
    protected $casts = [
        'metadata'   => 'object',
        'commission' => 'object',
        'invoice'    => 'object',
        'labour'     => 'object',
        'term'       => 'object',
        'address'       => 'object'
    ];

    /**
     * Job belongs to the quote.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class);
    }

    /**
     * One quote has one customer.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Job has many sales.
     */
    public function sales(): BelongsToMany
    {
        return $this->belongsToMany(SalesStaff::class, DBTable::PIVOT_JOBS_SALES, 'job_id', 'sales_id')->withPivot('priority', 'commission');
    }

    /**
     * @return BelongsToMany
     */
    public function primarySalesPerson()
    {
        return $this->belongsToMany(SalesStaff::class, DBTable::PIVOT_JOBS_SALES, 'job_id',
            'sales_id')->withPivot('priority', 'commission')->wherePivot('priority', 'primary');
    }

    /**
     * Job belongs to many material sales price.
     */
    public function materialSalesPrice(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, DBTable::PIVOT_JOBS_MATERIAL_SALES_PRICE, 'job_id', 'variant_id')->withPivot('variant_id', 'quantity', 'unit', 'total', 'product_id', 'material_from');
    }

    /**
     * Job belongs to many labour sales price.
     */
    public function labourSalesPrice(): BelongsToMany
    {
        return $this->belongsToMany(LabourProduct::class, DBTable::PIVOT_JOBS_LABOUR_SALES_PRICE, 'job_id', 'labour_product_id')->withPivot('quantity', 'unit', 'total');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function materials(): HasMany
    {
        return $this->hasMany(JobMaterialSale::class, 'job_id');
    }   

    /**
     * Job has many invoices.
     * @return HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'job_id');
    }
    
    public function futureStocks(): HasMany
    {
        return $this->hasMany(FutureStock::class, 'job_id')->with(['color.product']);
    }

    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function allocationsAndBackOrders()
    {
        return $this->hasMany(Allocation::class)
            ->where('amount', '>', 0)
            ->with(['color.product.supplier', 'currentStock'])
            ->select([
                'id', 
                'job_id', 
                'variant_id', 
                'client', 
                'date_required',
                'amount',
                'current_stock_id'
            ])
            ->union(
                $this->hasMany(BackOrder::class)
                ->where('amount', '>', 0)
                ->with(['color.product.supplier', 'futureStock'])
                ->select([
                    'id', 
                    'job_id', 
                    'variant_id', 
                    'client', 
                    'date_required',
                    'amount',
                    'future_stock_id'
                ])
            );
    }

    public function dispatches()
    {
        return $this->hasMany(AllocationDispatch::class, 'job_id');
    }

    public function creditorsPayables()
    {
        return $this->hasMany(Payable::class, 'job_id')->where('is_paid', '=', false);
    }

    public function paidPayables()
    {
        return $this->hasMany(RemittanceItem::class, 'job')
            ->with(['payable.supplier', 'paymentDue.contractor', 'remittance'])
            ->where('is_paid', '=', true);
    }

    public function contractorsPayables()
    {
        return $this->hasMany(PaymentsDue::class, 'job_id')->where('is_paid', '=', false);
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
