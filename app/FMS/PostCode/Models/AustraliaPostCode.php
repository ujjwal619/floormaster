<?php

namespace App\FMS\PostCode\Models;

use Illuminate\Database\Eloquent\Model;

class AustraliaPostCode extends Model
{
    protected $table = 'australia_postcodes';

    public $timestamps = false;

    protected $fillable = [
        'postcode',
        'suburb',
        'state',
        'dc',
        'type',
    ];
}
