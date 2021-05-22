<?php

namespace App\FMS\Site\Actions;

use App\FMS\Site\Manager;
use App\FMS\Site\Requests\SiteRequest;
use App\StartUp\BaseClasses\Controller\AdminController;

class CreateSite extends AdminController
{
    public function __invoke(SiteRequest $request, Manager $storeManager)
    {
        $siteId = $request->segment(2) ?? '0';
        $request->validate([
            'name' => 'required|unique:sites,name,'. $siteId,
        ]);

        if (!$site = $storeManager->create($request->only(['name']))) {
            abort('204', 'Could not Create Store.');
        }

        $user = $request->user();
        $user->sites()->attach([$site->id]);

        return $this->sendSuccessResponse([], 'Site added successfully.');
    }
}
