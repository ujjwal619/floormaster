<?php

namespace App\Data\Entities\Models\Stock;

use App\Constants\DBTable;
use App\Data\Entities\Models\Product\ProductVariant;
use App\FMS\Stock\Models\Allocation;
use App\FMS\Stock\Models\AllocationDispatch;
use App\FMS\Stock\Models\FutureStockReceiveGroup;
use Illuminate\Database\Eloquent\Model;

class CurrentStock extends Model
{
    protected $table = DBTable::CURRENT_STOCK;

    protected $fillable = [
        'batch',
        'roll_no',
        'size',
        'location',
        'nb',
        'supplier_inv_no',
        'unit_cost',
        'levy',
        'selling_price',
        'received_date',
        'gl_date',
        'sold',
        'future_stock_id',
        'is_invoiced',
        'site_id',
        'job_id',
        'job_material_id',
        'future_stock_receive_group_id',
        'quantity'
    ];

    public function color()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function stock()
    {
        return $this->color->stock();
    }

    public function allocations()
    {
        return $this->hasMany(Allocation::class, 'current_stock_id');
    }

    public function allocationDispatches()
    {
        return $this->hasMany(AllocationDispatch::class, 'current_stock_id');
    }

    public function coaNotUpdatedAllocationDispatches()
    {
        return $this->allocationDispatches()
            ->where('is_coa_updated', '=', false)
            ->whereNotNull('transaction_journal_id');
    }

    public function futureStock()
    {
        return $this->belongsTo(FutureStock::class, 'future_stock_id');
    }

    public function futureStockReceiveGroup()
    {
        return $this->belongsTo(FutureStockReceiveGroup::class, 'future_stock_receive_group_id');
    }
}
