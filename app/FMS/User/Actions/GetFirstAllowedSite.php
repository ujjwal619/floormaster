<?php

namespace App\FMS\User\Actions;

use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetFirstAllowedSite extends AdminController
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        $site = $user->newQuery()
            ->join('user_sites', 'user_sites.user_id', 'auth_users.id')
            ->join('sites', 'sites.id', 'user_sites.site_id')
            ->where('user_sites.user_id', $user->id)
            ->select(
                'sites.id as id',
                'sites.name as name'
            )
            ->first();

        if (!$site) {
            return new JsonResponse(['success' => 'true', 'data' => null, 'message' => 'No Site Access.']);
        }

        return $this->sendSuccessResponse($site->toArray());
    }
}
