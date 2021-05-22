<?php

namespace App\Data\Entities\Models\Customer\Setting;

use App\Constants\DBTable;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $table = DBTable::GENERAL_SETTING;

    protected $fillable = [
        'trading_name',
        'street',
        'town',
        'state',
        'code',
        'phone',
        'acn',
        'abn',
        'fax',
        'group_id',
        'postal_address',
        'delivery_address',
        'gst'
    ];

    protected $casts = ['postal_address' => 'object', 'delivery_address' => 'object'];
}
