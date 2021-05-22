<?php

namespace App\FMS\Job\Actions;

use App\Data\Entities\Models\Job\Job;
use App\StartUp\BaseClasses\Controller\AdminController;

class UpdateRecentlyCompleted extends AdminController
{
    public function __invoke(Job $job)
    {
        $job->fill(['recently_converted' => false])->save();
        return $this->sendSuccessResponse([]);
    }
}
