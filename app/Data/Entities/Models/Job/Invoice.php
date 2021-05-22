<?php

namespace App\Data\Entities\Models\Job;

use App\Constants\DBTable;
use App\FMS\Core\Traits\GetCreatedAtAttribute;
use App\FMS\Invoice\Model\Expense;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Invoice
 * @package App\Data\Entities\Models\Job
 */
class Invoice extends Model
{
    use GetCreatedAtAttribute;
    /**
     * Specify the table name.
     * @var string
     */
    protected $table = DBTable::JOB_INVOICES;

    /**
     * The following fields are fillable.
     * @var array
     */
    protected $fillable = [
        'date',
        'amount',
        'related_invoice',
        'remarks',
        'net_invoice',
        'gst',
        'retention_release_date',
        'retention_amount',
        'notes',
        'gst_amount',
        'total_receipts',
        'total_expenses',
        'balance_due'
    ];

    protected $dates = ['created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
