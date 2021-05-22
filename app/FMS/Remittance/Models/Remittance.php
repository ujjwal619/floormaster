<?php

namespace App\FMS\Remittance\Models;

use App\Constants\DBTable;
use App\Data\Entities\Models\Contractor\Contractor;
use App\Data\Entities\Models\Supplier\Supplier;
use App\FMS\Remittance\ValueObjects\DefaultItemStatus;
use App\FMS\Site\Models\Site;
use Illuminate\Database\Eloquent\Model;

class Remittance extends Model
{
    protected $table = DBTable::REMITTANCE;

    protected $fillable = [
        'site_id',
        'remittance_number',
        'remittance_type',
        'default_item_status',
        'payment_type',
        'cheque_date',
        'cheque_number',
        'invoice_date',
        'supplier_id',
        'contractor_id',
        'payee_name',
        'payee_street',
        'payee_town',
        'payee_state',
        'payee_code',
        'notes',
        'transaction_date',
        'is_paid'
    ];

    protected $casts = [
        'notes' => 'object'
    ];

    public function items()
    {
        return $this->hasMany(RemittanceItem::class);
    }

    public function payItems()
    {
        return $this->hasMany(RemittanceItem::class)->where('default_item_status', '=', DefaultItemStatus::PAY);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(
            function (Model $model) {
                $model->setAttribute('remittance_number', 'ABC-'.$model->getAttribute('id'));
            }
        );
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
