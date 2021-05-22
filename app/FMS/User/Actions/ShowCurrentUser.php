<?php

namespace App\FMS\User\Actions;

use App\FMS\User\Queries\UserDetail;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShowCurrentUser extends AdminController
{
    public function __invoke(Request $request, UserDetail $userDetail)
    {
        $user = $userDetail->fetch($request->user()->id);
        return new JsonResponse([
            'data' => $user,
            'meta' => [
                'is_super_admin' => $user->hasRole('super_admin')
            ],
        ]);
    }
}
