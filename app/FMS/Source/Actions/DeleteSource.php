<?php

namespace App\FMS\Source\Actions;

 use App\Data\Entities\Models\JobSource\JobSource;
 use App\StartUp\BaseClasses\Controller\AdminController;

 class DeleteSource extends AdminController
{
    public function __invoke(JobSource $jobSource)
    {
        if (!$jobSource->delete()) {
            abort(204, 'Could not delete source.');
        }

        return $this->sendSuccessResponse([], 'Source deleted Successfully.');
    }
 }
