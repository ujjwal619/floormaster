<?php

namespace App\Data\Entities\Models\Stock;

use App\Constants\DBTable;
use Illuminate\Database\Eloquent\Model;

class OrderReceipt extends Model
{
    protected $table = DBTable::ORDER_RECEIPT;

    protected $fillable = [
        'batch',
        'delivery_date',
        'roll_no',
        'quantity',
        'location',
        'notation'
    ];
}
