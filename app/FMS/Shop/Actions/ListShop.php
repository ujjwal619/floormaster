<?php

namespace App\FMS\Shop\Actions;

use App\FMS\Site\Models\Site;
use App\StartUp\BaseClasses\Controller\AdminController;

class ListShop extends AdminController
{
    public function __invoke(Site $site)
    {
        return $this->sendSuccessResponse($site->shops->toArray());
    }
}
