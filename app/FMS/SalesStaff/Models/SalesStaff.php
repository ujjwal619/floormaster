<?php

namespace App\FMS\SalesStaff\Models;

use App\Constants\DBTable;
use Illuminate\Database\Eloquent\Model;

class SalesStaff extends Model
{
    protected $table = DBTable::SALES_STAFF;

    protected $fillable = [
        'name',
        'is_active',
        'commission_calculation',
        'first_tier',
        'second_tier',
        'third_tier'
    ];

    protected $casts = [
        'first_tier' => 'object',
        'second_tier' => 'object',
        'third_tier' => 'object',
    ];
}
