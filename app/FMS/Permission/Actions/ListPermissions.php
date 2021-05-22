<?php

namespace App\FMS\Permission\Actions;

use App\StartUp\BaseClasses\Controller\AdminController;

class ListPermissions extends AdminController
{
    public function __invoke()
    {
        return $this->sendSuccessResponse(config('Permissions'));
    }
}
