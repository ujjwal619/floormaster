<?php

namespace App\FMS\Site\Actions;

use App\FMS\Product\Manager;
use App\FMS\Site\Models\Site;
use App\StartUp\BaseClasses\Controller\AdminController;

class ListProductBySite extends AdminController
{
    public function __invoke(Site $site, Manager $manager)
    {
        return $this->sendSuccessResponse($manager->getBySite($site->id)->toArray());
    }
}
