<?php

namespace App\FMS\PostCode;

use App\FMS\PostCode\Models\AustraliaPostCode;

class Manager
{
    private $australiaPostCode;

    public function __construct(AustraliaPostCode $australiaPostCode)
    {
        $this->australiaPostCode = $australiaPostCode;
    }

    public function findWhere(array $conditions = [])
    {
        return $this->australiaPostCode->where($conditions)->first();
    }
}
