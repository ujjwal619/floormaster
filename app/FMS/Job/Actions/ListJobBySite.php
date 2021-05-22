<?php

namespace App\FMS\Job\Actions;

use App\Data\Entities\Models\Job\Job;
use App\FMS\Site\Models\Site;
use App\StartUp\BaseClasses\Controller\AdminController;

class ListJobBySite extends AdminController
{
    public function __invoke(Site $site, Job $job)
    {
        $jobs = $job->newQuery()
            ->where('site_id', $site->id)
            ->get()
            ->toArray();

        return $this->sendSuccessResponse($jobs);
    }
}
