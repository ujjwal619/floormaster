<?php

namespace App\FMS\Site\Models;

use App\Constants\DBTable;
use App\Data\Entities\Models\Account\Account;
use App\Data\Entities\Models\Customer\Customer;
use App\Data\Entities\Models\JobSource\JobSource;
use App\Data\Entities\Models\Template\Template;
use App\Data\Entities\Models\Terms\TermsAndCondition;
use App\Data\Entities\Models\User\User as UserUser;
use App\FMS\SalesStaff\Models\SalesStaff;
use App\FMS\Shop\Models\Shop;
use App\FMS\TransactionJournal\Models\TransactionJournal;
use App\FMS\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $table = DBTable::SITES;

    protected $fillable = [
        'name',
        'gl_suffix',
        'letterhead_path',
        'delivery_address',
        'company_details',
        'postal_address',
        'gst',
        'gst_basis',
        'gl_recording',
        'gst_billed_on_sales_id',
        'gst_on_creditors_id',
        'trade_creditors_id',
        'trade_debtors_id',
        'money_in_trust_id',
        'job_retention_id',
        'cheque_account_id',
        'delivery_bailing_id',
        'discounts_received_id',
        'retained_earnings_id',
        'current_earnings_id',
        'retention_release_user_id',
        'retention_release_days',
        'customer_complaint_unresolved_user_id',
        'customer_complaint_unresolved_days',
        'stock_below_reorder_user_id',
        'purchase_orders_overdue_user_id',
        'jobs_invoiced_less_than_quoted_at_complition_user_id',
        'quote_prefix',
        'quote_number_from',
        'quote_number_to',
    ];

    protected $casts = [
        'delivery_address' => 'object',
        'company_details' => 'object',
        'postal_address' => 'object'
    ];

    public function sources()
    {
        return $this->hasMany(JobSource::class);
    }

    public function terms()
    {
        return $this->hasMany(TermsAndCondition::class);
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function transactionJournals()
    {
        return $this->hasMany(TransactionJournal::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function salesStaffs()
    {
        return $this->hasMany(SalesStaff::class);
    }

    public function templates()
    {
        return $this->hasMany(Template::class);
    }

        public function getCompanyDetailsAttribute($value)
    {
        return $value;
    }

    public function getDeliveryAddressAttribute($value)
    {
        return $value;
    }

    public function getPostalAddressAttribute($value)
    {
        return $value;
    }

    public function gstBilledOnSales()
    {
        return $this->belongsTo(Account::class, 'gst_billed_on_sales_id');
    }

    public function gstOnCreditors()
    {
        return $this->belongsTo(Account::class, 'gst_on_creditors_id');
    }

    public function tradeCreditors()
    {
        return $this->belongsTo(Account::class, 'trade_creditors_id');
    }

    public function tradeDebtors()
    {
        return $this->belongsTo(Account::class, 'trade_debtors_id');
    }

    public function moneyInTrust()
    {
        return $this->belongsTo(Account::class, 'money_in_trust_id');
    }

    public function jobRetention()
    {
        return $this->belongsTo(Account::class, 'job_retention_id');
    }

    public function chequeAccount()
    {
        return $this->belongsTo(Account::class, 'cheque_account_id');
    }

    public function deliveryBailing()
    {
        return $this->belongsTo(Account::class, 'delivery_bailing_id');
    }

    public function discountsReceived()
    {
        return $this->belongsTo(Account::class, 'discounts_received_id');
    }

    public function retainedEarnings()
    {
        return $this->belongsTo(Account::class, 'retained_earnings_id');
    }

    public function currentEarnings()
    {
        return $this->belongsTo(Account::class, 'current_earnings_id');
    }

    public function automatedMemo()
    {
        return $this->hasOne(AutomatedMemo::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, DBTable::USER_SITES, 'site_id', 'user_id');
    }

    public function retentionReleaseUser()
    {
        return $this->belongsTo(User::class, 'retention_release_user_id');
    }

    public function customerComplaintUnresolvedUser()
    {
        return $this->belongsTo(User::class, 'customer_complaint_unresolved_user_id');
    }

    public function stockBelowReorderUser()
    {
        return $this->belongsTo(User::class, 'stock_below_reorder_user_id');
    }

    public function purchaseOrdersOverdueUser()
    {
        return $this->belongsTo(User::class, 'purchase_orders_overdue_user_id');
    }

    public function jobsInvoicedLessThanQuotedAtComplitionUser()
    {
        return $this->belongsTo(User::class, 'jobs_invoiced_less_than_quoted_at_complition_user_id');
    }

    public function shops()
    {
        return $this->hasMany(Shop::class);
    }
}
