<?php

namespace App\FMS\Client\Actions;

use App\FMS\Client\Manager;
use App\FMS\Client\Requests\CreateRequest;
use App\FMS\Site\Models\Site;
use App\StartUp\BaseClasses\Controller\AdminController;

class CreateClient extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:client.access.add.client']);
    }

    public function __invoke(Site $site, CreateRequest $request, Manager $clientManager)
    {
        if (!$clientManager->create($site->id, $request->all())) {
            abort('204', 'Could not create Client.');
        }

        return $this->sendSuccessResponse([], 'Client added successfully.');
    }
}
