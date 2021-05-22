<?php

namespace App\FMS\Site\Actions;

use App\FMS\Site\Manager;
use App\FMS\Site\Models\Site;
use App\FMS\Site\Requests\SiteRequest;
use App\StartUp\BaseClasses\Controller\AdminController;

class UpdateSite extends AdminController
{
    public function __invoke(Site $site, SiteRequest $request, Manager $storeManager)
    {
        $storeManager->update($site, $request->all());
        return $this->sendSuccessResponse([], 'Site updated successfully.');
    }
}
