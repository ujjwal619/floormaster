<?php

namespace App\Data\Entities\Models\Template;

use App\Constants\DBTable;
use App\Data\Entities\Models\Account\Account;
use App\Data\Entities\Traits\ModelTrait;
use App\Data\Traits\GetLink;
use App\FMS\Core\Traits\BelongsToSite;
use App\FMS\Site\Models\Site;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Template
 * @package App\Data\Entities\Models\Template
 */
class Template extends Model
{
    use ModelTrait, GetLink, BelongsToSite;

    /**
     * @var string
     */
    protected $table = DBTable::TEMPLATES;

    /**
     * @var array
     */
    protected $casts = [
        'labour_products'   => 'object',
        'material_products' => 'object',
        'customer_details' => 'object',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'customer_details',
        'labour_products',
        'material_products',
        'site_id',
        'sales_code_id',
        'costed_commission',
        'quote_price',
        'markup_guide',
        'margin',
        'gp',
        'net_cost',
        'total_cost',
        'material_total',
        'labour_total',
    ];

    public function salesCode()
    {
        return $this->belongsTo(Account::class, 'sales_code_id');
    }
}
