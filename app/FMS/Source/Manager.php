<?php

namespace App\FMS\Source;

use App\Data\Entities\Models\JobSource\JobSource;

class Manager
{
    private $jobSource;

    public function __construct(JobSource $jobSource)
    {
        $this->jobSource = $jobSource;
    }

    public function create(array $details)
    {
        return $this->jobSource->fill($details)->forceFill(['name' => $details['title'], 'site_id' => $details['site_id']])->save();
    }

    public function update(JobSource $jobSource, array $details)
    {
        return $jobSource->fill($details)->save();
    }

    public function findWhere(array $conditions = [])
    {
        return $this->jobSource->where($conditions)->first();
    }
}
