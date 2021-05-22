<?php

namespace App\FMS\CostingTemplate\Actions;

use App\Data\Entities\Models\Template\Template;
use App\StartUp\BaseClasses\Controller\AdminController;

class ShowTemplate extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:job.template|job.template.view.costing']);
    }

    public function __invoke(Template $template)
    {
        $template->load(
            'site', 'salesCode'
        );

        return $this->sendSuccessResponse($template->toArray());
    }
}
