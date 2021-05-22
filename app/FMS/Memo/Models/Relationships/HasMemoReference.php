<?php

namespace App\FMS\Memo\Models\Relationships;

use App\Data\Entities\Models\Memo\Memo;

trait HasMemoReference
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function memoReferences()
    {
        return $this->morphMany(Memo::class, 'reference');
    }
}
