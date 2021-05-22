<?php

namespace App\Data\Entities\Models\Customer;

use App\Constants\DBTable;
use App\Data\Entities\Accessors\Customer\CustomerAccessor;
use App\Data\Entities\Models\Customer\Setting\Setting;
use App\Data\Entities\Models\Customer\Site\Site;
use App\Data\Entities\Models\JobSource\JobSource;
use App\Data\Entities\Models\Quote\Quote;
use App\Data\Entities\Models\Terms\TermsAndCondition;
use App\Data\Entities\Models\User\User;
use App\Data\Entities\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * Class Customer
 * @property Collection jobSources
 * @property Collection sales
 * @property Collection sites
 * @property string     trading_name
 * @package App\Data\Entities\Models
 */
class Customer extends Model
{
    use ModelTrait, SoftDeletes, CustomerAccessor;

    /**
     * Specify the table name.
     * @var string
     */
    protected $table = DBTable::CUSTOMERS;

    /**
     * Cast the following field to following types.
     * @var array
     */
    protected $casts = [
        'address'          => 'object',
        'terms'            => 'object'
    ];

    /**
     * The following fields siteare fillable.
     * @var array
     */
    protected $fillable = [
        'title',
        'site_id',
        'firstname',
        'trading_name',
        'address',
        'attention',
        'phone',
        'work_phone',
        'mobile',
        'email',
        'fax',
        'terms',
        'key_no',
        'notes',
        'term_id'
    ];

    /**
     * One customer has many sites.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sites(): HasMany
    {
        return $this->hasMany(Site::class)->select(['id', 'shop_name', 'gl_suffix']);
    }

    /**
     * Customer has setting.
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    // public function setting(): HasOne
    // {
    //     return $this->hasOne(Setting::class);
    // }

    /**
     * Customer has many sales.
     */
    public function sales(): BelongsToMany
    {
        return $this->belongsToMany(User::class, DBTable::PIVOT_CUSTOMER_SALES, 'customer_id', 'sales_id');
    }

    /**
     * Many customer has many job sources
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function jobSources(): BelongsToMany
    {
        return $this->belongsToMany(JobSource::class, DBTable::PIVOT_CUSTOMER_JOB_SOURCE, 'customer_id', 'job_source_id');
    }

    /**
     * @return HasMany
     */
    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class, 'customer_id');
    }

    public function term()
    {
        return $this->belongsTo(TermsAndCondition::class, 'term_id');
    }
}
