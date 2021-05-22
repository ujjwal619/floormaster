<?php
/**
 * Created by PhpStorm.
 * User: bijayaprasadkuikel
 * Date: 8/10/18
 * Time: 10:22 PM
 */

namespace App\Data\Entities\Models\Customer\Setting;


use App\Constants\DBTable;
use App\Data\Entities\Models\Customer;
use App\Data\Entities\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Setting
 * @package App\Data\Entities\Models\Customer\Setting
 */
class Setting extends Model
{
    use SoftDeletes, ModelTrait;
    /**
     * @var string
     */
    protected $table = DBTable::CUSTOMER_SETTINGS;

    /**
     * The following fields are fillable.
     * @var array
     */
    protected $fillable = ['customer_id', 'general'];

    /**
     * Cast the following fields.
     * @var array
     */
    protected $casts = [
        'general' => 'object',
    ];

    /**
     * Settings belongs to the customer.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}