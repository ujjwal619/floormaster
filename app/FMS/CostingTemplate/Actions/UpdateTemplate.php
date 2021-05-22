<?php

namespace App\FMS\CostingTemplate\Actions;

use App\Data\Entities\Models\Template\Template;
use App\Domain\Admin\Requests\Template\TemplateRequest;
use App\FMS\CostingTemplate\Manager;
use App\StartUp\BaseClasses\Controller\AdminController;

class UpdateTemplate extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:job.template.edit.screen.1']);
        $this->middleware(['permission:job.template.edit.costing']);
    }

    public function __invoke(Template $template, TemplateRequest $request, Manager $manager)
    {
        if (!$manager->update($template, $request->all())) {
            abort('204', 'Could not update template.');
        }

        return $this->sendSuccessResponse($template->fresh()->toArray(), 'Template updated successfully.');
    }
}
