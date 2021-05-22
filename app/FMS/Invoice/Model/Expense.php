<?php

namespace App\FMS\Invoice\Model;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $table = 'invoice_expenses';

    protected $fillable = ['debit_date', 'gl_code', 'expense_id', 'site_id', 'net_amount', 'payee', 'notes'];
}
