<?php

namespace App\FMS\Job\Handlers;

use App\FMS\Job\Events\CalculateJobTotal;
use App\FMS\Job\Manager;

class CalculateJobTotalHandler
{
    private $jobManager;
    public function __construct(
        Manager $jobManager
    ) {
          $this->jobManager = $jobManager;
    }

    public function handle(CalculateJobTotal $calculateJobTotal)
    {
        $job = $calculateJobTotal->job();
        $this->jobManager->calculateJobTotal($job);
    }
}
