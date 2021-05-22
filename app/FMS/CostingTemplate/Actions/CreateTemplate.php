<?php

namespace App\FMS\CostingTemplate\Actions;

use App\Domain\Admin\Requests\Template\TemplateRequest;
use App\FMS\CostingTemplate\Manager;
use App\FMS\Site\Models\Site;
use App\StartUp\BaseClasses\Controller\AdminController;

class CreateTemplate extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:job.template.add.template']);
    }

    public function __invoke(Site $site, TemplateRequest $request, Manager $templateManager)
    {
        if (!$template = $templateManager->create($site->id, $request->all())) {
            abort('204', 'Could not create Template.');
        }

        return $this->sendSuccessResponse($template->toArray(), 'Template added successfully.');
    }
}
