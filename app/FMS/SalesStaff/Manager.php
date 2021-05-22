<?php

namespace App\FMS\SalesStaff;

use App\FMS\SalesStaff\Models\SalesStaff;

class Manager
{
    private $salesStaff;

    public function __construct(SalesStaff $salesStaff)
    {
        $this->salesStaff = $salesStaff;
    }

    public function create(int $siteId, array $details)
    {
        return $this->salesStaff->fill($details)->forceFill(['site_id' => $siteId])->save();
    }

    public function update(SalesStaff $salesStaff, array $details)
    {
        return $salesStaff->fill($details)->save();
    }

    public function findWhere(array $conditions = [])
    {
        return $this->salesStaff->where($conditions)->first();
    }
}
