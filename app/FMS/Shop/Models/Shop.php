<?php

namespace App\FMS\Shop\Models;

use App\Constants\DBTable;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $table = DBTable::SHOPS;

    protected $fillable = [
        'name',
        'gl_suffix',
        'letterhead_path',
        'street',
        'town',
        'state',
        'code',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
