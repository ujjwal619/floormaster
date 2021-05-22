<?php

namespace App\Data\Traits;

trait GetLink
{
    public function getPreviousLink(int $id)
    {
        return $this->where('id', '<', $id)->max('id');
    }

    public function getNextLink(int $id)
    {
        return $this->where('id', '>', $id)->min('id');
    }
}
