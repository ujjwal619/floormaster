<?php

namespace App\FMS\Job\Actions;

use App\Domain\Admin\Services\Template\TemplateService;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ListMergedTemplates extends AdminController
{
    public function __invoke(Request $request, TemplateService $templateService)
    {
        $tempaltes = $templateService->getSelected($request->all());
        return $this->sendSuccessResponse($tempaltes);
    }
}
