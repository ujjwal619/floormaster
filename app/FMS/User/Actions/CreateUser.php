<?php

namespace App\FMS\User\Actions;

use App\FMS\User\Manager;
use App\FMS\User\Requests\UserRequest;
use App\StartUp\BaseClasses\Controller\AdminController;

class CreateUser extends AdminController
{
    public function __invoke(UserRequest $request, Manager $userManager)
    {
        if ($user = $userManager->create($request->all())) {
            return $this->sendSuccessResponse($user->toArray(), 'User created Successfully.');
        }

        return $this->sendError();
    }
}
