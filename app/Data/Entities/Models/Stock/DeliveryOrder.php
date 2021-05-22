<?php

namespace App\Data\Entities\Models\Stock;

use App\Constants\DBTable;
use Illuminate\Database\Eloquent\Model;

class DeliveryOrder extends Model
{
    protected $table = DBTable::DELIVERY_ORDERS;

    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'invoice_total',
        'quantity',
        'discounted_unit_price',
        'delivery',
        'gst_credit',
    ];
}
