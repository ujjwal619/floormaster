<?php

namespace App\FMS\Site\Actions;

use App\FMS\Site\Models\Site;
use App\StartUp\BaseClasses\Controller\AdminController;

class ShowSite extends AdminController
{
    public function __invoke(Site $site)
    {
        $site->load(['chequeAccount',  'shops']);
        return $this->sendSuccessResponse($site->toArray());
    }
}
