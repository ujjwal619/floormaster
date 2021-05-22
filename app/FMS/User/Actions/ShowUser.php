<?php

namespace App\FMS\User\Actions;

use App\FMS\User\Queries\UserDetail;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\JsonResponse;

class ShowUser extends AdminController
{
    public function __invoke(string $userId, UserDetail $userDetail)
    {
        $user = $userDetail->fetch($userId);
        return new JsonResponse([
            'data' => $user,
            'meta' => [
                'is_super_admin' => $user->hasRole('super_admin')
            ],
        ]);
    }
}
