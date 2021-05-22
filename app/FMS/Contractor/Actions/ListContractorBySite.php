<?php

namespace App\FMS\Contractor\Actions;

use App\Data\Entities\Models\Contractor\Contractor;
use App\FMS\Site\Models\Site;
use App\StartUp\BaseClasses\Controller\AdminController;

class ListContractorBySite extends AdminController
{
    public function __invoke(Site $site, Contractor $contractor)
    {
        $listContractor = $contractor->newQuery()
            ->where('site_id', $site->id)
            ->get()
            ->toArray();

        return $this->sendSuccessResponse($listContractor);
    }
}
