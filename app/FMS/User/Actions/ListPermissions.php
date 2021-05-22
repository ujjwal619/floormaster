<?php

namespace App\FMS\User\Actions;

use App\FMS\User\Models\User;
use App\StartUp\BaseClasses\Controller\AdminController;

class ListPermissions extends AdminController
{
    public function __invoke(User $user)
    {
        return $this->sendSuccessResponse($user->getDirectPermissions());
    }
}
