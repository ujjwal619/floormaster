<?php

namespace App\FMS\Core\Traits;

use App\FMS\Site\Models\Site;

trait BelongsToSite
{
    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
