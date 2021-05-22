<?php

namespace App\Data\Entities\Models\Terms;

use App\Constants\DBTable;
use App\Data\Entities\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TermsAndCondition
 * @package App\Data\Entities\Models\Terms
 */
class TermsAndCondition extends Model
{
    use ModelTrait;

    /**
     * Specify the name of the table.
     * @var string
     */
    protected $table = DBTable::TERMS_AND_CONDITIONS;

    /**
     * The following fields are fillable.
     * @var array
     */
    protected $fillable = [
        'name',
        'due',
        'metadata',
        'terms',
        'site_id'
    ];

    /**
     * Cast the following fields to following types.
     * @var array
     */
    protected $casts = [
        'due'      => 'object',
        'metadata' => 'object',
        'terms'    => 'object',
    ];

}
