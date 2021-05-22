<?php

namespace App\FMS\Core\Traits;

trait GetMorphAlias
{
    /**
     * @return string
     */
    public function getMorphAlias(): string
    {
        return self::MORPH_ALIAS;
    }
}
