<?php

namespace App\FMS\Stock\Models;

use App\Constants\DBTable;
use App\Data\Entities\Models\Job\Job;
use App\Data\Entities\Models\Product\ProductVariant;
use App\Data\Entities\Models\Stock\CurrentStock;
use App\FMS\TransactionJournal\Models\TransactionJournal;
use Illuminate\Database\Eloquent\Model;

class AllocationDispatch extends Model
{
    protected $table = DBTable::ALLOCATION_DISPATCH;

    protected $fillable = [
        'job_id',
        'job_material_id',
        'date',
        'amount',
        'supplier_product_color',
        'return_location',
        'variant_id',
        'current_stock_id',
        'site_id',
        'was',
        'left',
        'total',
        'transaction_journal_id',
        'is_coa_updated',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function allocation()
    {
        return $this->belongsTo(Allocation::class, 'allocation_id');
    }

    public function currentStock()
    {
        return $this->belongsTo(CurrentStock::class, 'current_stock_id');
    }

    public function color()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function transactionJournal()
    {
        return $this->belongsTo(TransactionJournal::class,  'transaction_journal_id');
    }
}
