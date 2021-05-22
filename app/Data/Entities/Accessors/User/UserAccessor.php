<?php

namespace App\Data\Entities\Accessors\User;

/**
 * Trait UserAccessor
 * @package App\Data\Entities\Accessors\User
 */
trait UserAccessor
{
    /**
     * @return string
     */
    public function getFormattedFullNameAttribute(): string
    {
        return sprintf('%s %s', $this->full_name->first_name, $this->full_name->last_name);
    }
}
