<?php

namespace App\Data\Entities\Models\Supplier;

use App\Constants\DBTable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SupplierSite
 * @package App\Data\Entities\Models\Supplier
 */
class SupplierSite extends Model
{
    protected $table = DBTable::SUPPLIER_SITES;
    /**
     * @var array
     */
    protected $fillable = [
        'shop_name',
        'gl_suffix',
    ];

    /**
     * A site belongs to a supplier.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
