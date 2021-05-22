<?php

namespace App\FMS\Site\Actions;

use App\FMS\Site\Manager;
use App\FMS\Site\Models\Site;
use App\FMS\Site\Requests\SiteRequest;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class IsMySite extends AdminController
{
    public function __invoke(
        Site $site, 
        Request $request, 
        Manager $storeManager
    ) {
        return $this->sendSuccessResponse(['is_my_site' => $storeManager->isUserSite($request->user(), $site->id)], 'Success.');
    }
}
