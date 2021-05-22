<?php

namespace App\FMS\Memo\Models\Relationships;

interface MemoReferenceable
{
    /**
     * @return mixed
     */
    public function memoReferences();
}
