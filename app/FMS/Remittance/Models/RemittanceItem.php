<?php

namespace App\FMS\Remittance\Models;

use App\Constants\DBTable;
use App\Data\Entities\Models\Contractor\PaymentsDue;
use App\FMS\Supplier\Models\Payable;
use Illuminate\Database\Eloquent\Model;

class RemittanceItem extends Model
{
    protected $table = DBTable::REMITTANCE_ITEMS;

    protected $fillable = [
        'order_no',
        'supplier_reference',
        'invoice_amount',
        'goods',
        'freight',
        'levy',
        'gst',
        'goods_cost_ac',
        'freight_cost_ac',
        'levy_cost_ac',
        'discount',
        'comments',
        'job',
        'gross_payment',
        'adjustment',
        'net_payment',
        'payable_id',
        'payment_due_id',
        'is_paid',
        'default_item_status'
    ];

    public function remittance()
    {
        return $this->belongsTo(Remittance::class, 'remittance_id');
    }

    public function payable()
    {
        return $this->belongsTo(Payable::class, 'payable_id');
    }

    public function paymentDue()
    {
        return $this->belongsTo(PaymentsDue::class, 'payment_due_id');
    }
}
