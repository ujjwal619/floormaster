<?php

namespace App\FMS\Source\Actions;

use App\Data\Entities\Models\JobSource\JobSource;
use App\FMS\Site\Models\Site;
use App\StartUp\BaseClasses\Controller\AdminController;

class ListSource extends AdminController
{
    public function __invoke(Site $site, JobSource $jobSource)
    {
        $sources = $jobSource->newQuery()
            ->where('site_id', $site->id)
            ->get()
            ->toArray();

        return $this->sendSuccessResponse($sources);
    }
}
