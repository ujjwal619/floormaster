<?php

namespace App\FMS\Site\Actions;

use App\FMS\Site\Models\Site;
use App\StartUp\BaseClasses\Controller\AdminController;

class ListUsersBySite extends AdminController
{
    public function __invoke(Site $site)
    {
        return $this->sendSuccessResponse($site->users->toArray());
    }
}
