<?php

namespace App\FMS\Core\Traits;

use Carbon\Carbon;

trait GetCreatedAtAttribute
{
    public function getCreatedAtAttribute($value)
    {
        return (new Carbon($value))->toDateString();
    }
}
