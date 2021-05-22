<?php

namespace App\FMS\CostingTemplate\Actions;

use App\Data\Entities\Models\Template\Template;
use App\StartUp\BaseClasses\Controller\AdminController;

class DeleteTemplate extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:job.template.delete.template']);
    }

    public function __invoke(Template $template)
    {
        if (!$template->delete()) {
            abort('204', 'Could not delete Template.');
        }

        return $this->sendSuccessResponse([], 'Template deleted successfully.');
    }
}
