<?php

namespace App\FMS\Client\Actions;

use App\Data\Entities\Models\Customer\Customer;
use App\Data\Entities\Models\Job\Job;
use App\StartUp\BaseClasses\Controller\AdminController;

class ListRelatedJobs extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:client.access|job.access']);
    }

    public function __invoke(Customer $customer, Job $job)
    {
        $jobs = $job->newQuery()
            ->where('tbl_jobs.customer_id', $customer->id)
            ->get();

        return $this->sendSuccessResponse($jobs->toArray());
    }
}
