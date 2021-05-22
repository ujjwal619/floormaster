<?php

namespace App\Data\Entities\Models\JobSource;

use App\Constants\DBTable;
use App\Data\Entities\Models\Customer\Customer;
use App\Data\Entities\Models\Supplier\Supplier;
use App\Data\Entities\Traits\ModelTrait;
use App\Data\Entities\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class JobSource
 * @package App\Data\Entities\Models\JobSource
 */
class JobSource extends Model
{
    use UuidTrait, SoftDeletes, ModelTrait;
    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $table = DBTable::JOB_SOURCES;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'title',
    ];

    /**
     * Many job source has many customers.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function customers()
    {
        return $this->belongsToMany(Customer::class, DBTable::PIVOT_CUSTOMER_JOB_SOURCE, 'job_source_id', 'customer_id');
    }

    /**
     * A job source might belong to many supplier.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, DBTable::PIVOT_JOB_SOURCE_SUPPLIER);
    }
}
