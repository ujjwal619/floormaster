<?php

namespace App\FMS\Site\Models;

use App\Constants\DBTable;
use Illuminate\Database\Eloquent\Model;

class AutomatedMemo extends Model
{
    protected $table = DBTable::SITE_AUTOMATED_MEMOS;

    protected $fillable = [
        'retention_release_user',
        'retention_release_days',
        'customer_complaint_unresolved_user',
        'customer_complaint_unresolved_days',
        'stock_below_reorder_user',
        'purchase_orders_overdue_user',
        'jobs_invoiced_less_than_quoted_at_complition_user',
    ];
}
