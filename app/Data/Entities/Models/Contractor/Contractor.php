<?php

namespace App\Data\Entities\Models\Contractor;

use App\Constants\DBTable;
use App\Data\Entities\Traits\ModelTrait;
use App\Data\Traits\GetLink;
use App\FMS\Site\Models\Site;
use Illuminate\Database\Eloquent\Model;
use App\FMS\Remittance\Models\Remittance;
use App\FMS\Remittance\Models\RemittanceItem;

class Contractor extends Model
{
    use ModelTrait, GetLink;

    protected $table = DBTable::CONTRACTOR;

    protected $fillable = [
        'name',
        'street',
        'suburb',
        'state',
        'postcode',
        'phone',
        'key_no',
        'is_active',
        'vehicle',
        'rego',
        'expires',
        'license',
        'tfn',
        'abn',
        'vn',
        'tax',
        'bank',
        'contractor_liability_account',
        'cost_of_sales_account',
        'tax_liability_account',
        'deductions',
        'public_liability_insurance',
        'workers_comp_insurance',
        'note',
        'collects_gst',
        'site_id'
    ];

    protected $casts = [
        'bank'   => 'object',
        'tax_liability_account'   => 'object',
        'deductions'   => 'object',
        'public_liability_insurance'   => 'object',
        'workers_comp_insurance' => 'object',
    ];

    public function payments()
    {
        return $this->hasMany(PaymentsDue::class, 'contractor_id')->where('is_paid', '=', false);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function remittanceItems()
    {
        return $this->hasManyThrough(RemittanceItem::class, Remittance::class, 'contractor_id', 'remittance_id');
    }
}
