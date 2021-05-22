<?php

namespace App\Data\Entities\Models\Account;

use App\Constants\DBTable;
use App\FMS\CashBook\Models\CashBook;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = DBTable::ACCOUNT;

    protected $fillable = [
        'family',
        'name',
        'type',
        'code',
        'gst_applicable',
        'reports_to',
        'opening_balance',
        'account_balance',
        'total_balance',
        'site_id',
    ];

    public function reporters()
    {
        return $this->hasMany(Account::class, 'reports_to');
    }

    public function cashBooks()
    {
        return $this->hasMany(CashBook::class, 'account_id');
    }
}
