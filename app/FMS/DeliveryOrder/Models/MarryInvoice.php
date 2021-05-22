<?php

namespace App\FMS\CurrentOrder\Models;

use App\Constants\DBTable;
use Illuminate\Database\Eloquent\Model;

class MarryInvoice extends Model
{
    protected $table = DBTable::STOCK_MARRY_INVOICES;

    protected $fillable = [
        'future_stock_id',
        'current_stock_id',
        'current_order_id',
        'site_id',
        'invoice_number',
        'invoice_date',
        'invoice_total',
        'discounted_unit_price',
        'delivery',
        'levy',
        'gst_credit',
        'quantity',
    ];
}