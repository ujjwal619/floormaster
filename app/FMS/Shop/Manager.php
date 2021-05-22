<?php

namespace App\FMS\Shop;

use App\FMS\Shop\Models\Shop;

class Manager
{
    private $shop;

    public function __construct(Shop $shop)
    {
        $this->shop = $shop;
    }

    public function findWhere(array $conditions = [])
    {
        return $this->shop->where($conditions)->first();
    }
}
