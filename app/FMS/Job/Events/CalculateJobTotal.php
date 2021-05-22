<?php

namespace App\FMS\Job\Events;

use App\Data\Entities\Models\Job\Job;

class CalculateJobTotal
{
    public $job;

    public function __construct(Job $job)
    {
        $this->job = $job->load(['invoices']);
    }

    public function job()
    {
        return $this->job;
    }
}
