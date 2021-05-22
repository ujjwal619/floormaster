<?php

namespace App\Data\Entities\Models\User;

use App\Constants\DBTable;
use App\Data\Entities\Accessors\User\UserAccessor;
use App\Data\Entities\Models\Customer\Customer;
use App\Data\Entities\Models\Job\Job;
use App\Data\Entities\Models\Memo\Memo;
use App\Data\Entities\Models\Quote\Quote;
use App\Data\Entities\Models\Supplier\Supplier;
use App\Data\Entities\Traits\UuidTrait;
use Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Pagination\Paginator;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 * @package App\Data\Entities\Models\User
 *
 * ============ Attributes =================
 * @property string  $id
 * @property string  $username
 * @property string  $email
 * @property string  $password
 * @property string  $display_name
 * @property boolean $is_first_login
 * @property string  $created_by
 * @property string  $updated_by
 * @property string  $deleted_by
 * @property object  full_name
 * @property string  status
 * ============ Relations ===================
 *
 * ============ Accessors ===================
 *
 */
class User extends Authenticatable
{
    use Notifiable, UuidTrait;
    use HasRoles, UserAccessor;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $table = DBTable::AUTH_USERS;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'full_name',
        'password',
        'display_name',
        'is_first_login',
        'created_by',
        'status',
        'updated_by',
        'deleted_by',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'full_name'      => 'object',
        'is_first_login' => 'boolean',
    ];

    /**
     * User Model Boot Method
     */
    public static function boot()
    {
        parent::boot();

        static::updating(
            function (User $user) {
                $user->setAttribute('created_by_id', is_null(currentUser()) ? null : currentUser()->id);
            }
        );

        static::updating(
            function (User $user) {
                $user->setAttribute('updated_by_id', is_null(currentUser()) ? null : currentUser()->id);
            }
        );

        self::deleting(
            function (User $user) {
                $user->setAttribute('deleted_by_id', is_null(currentUser()) ? null : currentUser()->id)->save();
            }
        );
    }

    /**
     * @param string $password
     */
    public function setPasswordAttribute(string $password)
    {
        $this->attributes['password'] = app('hash')->needsRehash($password) ? Hash::make($password) : $password;
    }

    /**
     * Sales user belongs to many customers.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function customers()
    {
        return $this->belongsToMany(Customer::class, DBTable::PIVOT_CUSTOMER_SALES, 'sales_id', 'customer_id');
    }

    /**
     * A sales staff user might have many suppliers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function suppliers()
    {
       return $this->belongsToMany(Supplier::class, DBTable::PIVOT_SALES_STAFF_SUPPLIER, 'sales_id');
    }

    /**
     * Sales user belongs to many quotes.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function quotes()
    {
        return $this->belongsToMany(Quote::class, DBTable::PIVOT_QUOTES_SALES, 'sales_id', 'customer_id');
    }

    /**
     * Sales user belongs to many jobs.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function jobs()
    {
        return $this->belongsToMany(Job::class, DBTable::PIVOT_JOBS_SALES, 'sales_id', 'customer_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function memos()
    {
        return $this->hasMany(Memo::class);
    }

    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        $page = $page ?: Paginator::resolveCurrentPage($pageName);$perPage = $perPage ?: $this->model->getPerPage();$results = ($total = $this->toBase()->getCountForPagination())
                                    ? $this->forPage($page, $perPage)->get($columns)
                                    : $this->model->newCollection();return new \App\Pagination\CustomPaginator($results, $total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ]);
    }
}
