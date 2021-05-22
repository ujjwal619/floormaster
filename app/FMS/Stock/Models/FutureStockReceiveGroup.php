<?php

namespace App\FMS\Stock\Models;

use App\Constants\DBTable;
use App\FMS\TransactionJournal\Models\TransactionJournal;
use Illuminate\Database\Eloquent\Model;

class FutureStockReceiveGroup extends Model
{
    protected $table = DBTable::FUTURE_STOCK_RECEIVE_GROUP;

    protected $fillable = [
    ];

    public function transactionJournal()
    {
        return $this->hasOne(TransactionJournal::class);
    }
}
