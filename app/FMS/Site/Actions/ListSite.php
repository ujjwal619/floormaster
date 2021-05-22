<?php

namespace App\FMS\Site\Actions;

use App\FMS\Site\Queries\ListUserSites;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ListSite extends AdminController
{
    public function __invoke(ListUserSites $listUserSites, Request $request)
    {
        $for = $request->get('for');

        return $this->sendSuccessResponse(
            $listUserSites->fetch($request->user(), $for)
        );
    }
}
