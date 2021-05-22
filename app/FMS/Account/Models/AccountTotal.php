<?php

namespace App\FMS\Account\Models;

use Illuminate\Database\Eloquent\Model;

class AccountTotal extends Model
{
    protected $table = 'account_yearly_monthly_total';

    protected $fillable = [
        'account_id',
        'site_id',
        'amount',
        'type',
        'date',
        'from',
        'to',
    ];
}