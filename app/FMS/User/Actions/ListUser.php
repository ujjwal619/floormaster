<?php

namespace App\FMS\User\Actions;

use App\FMS\User\Queries\UserList;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ListUser extends AdminController
{
    public function __invoke(UserList $userList, Request $request)
    {
        return $this->sendSuccessResponse($userList->fetch($request));
    }
}
