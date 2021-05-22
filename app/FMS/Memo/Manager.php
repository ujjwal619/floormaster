<?php

namespace App\FMS\Memo;

use App\Data\Entities\Models\Memo\Memo;
use App\FMS\Memo\Models\Relationships\MemoReferenceable;

class Manager
{
    private $product;

    public function __construct(Memo $memo)
    {
        $this->memo = $memo;
    }

    public function create(MemoReferenceable $memoReferenceable, array $details)
    {
        $memo = $this->memo->reference()->associate($memoReferenceable);

        return $this->memo->fill($details)->save();
    }

    private function save(Memo $memo, array $details)
    {
        return $memo->fill($details)->save();
    }
}
