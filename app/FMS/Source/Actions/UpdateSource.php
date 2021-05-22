<?php

namespace App\FMS\Source\Actions;

use App\Data\Entities\Models\JobSource\JobSource;
use App\Domain\Admin\Requests\JobSource\JobSourceRequest;
use App\FMS\Source\Manager;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Response;

class UpdateSource extends AdminController
{
    public function __invoke(
        JobSource $jobSource, 
        JobSourceRequest $request, 
        Manager $sourceManager
    ) {
        $details = $request->all();
        if ($sourceManager->findWhere([
            'site_id' => $details['site_id'], 
            'title' => $details['title'],
            ['id' , '<>', $jobSource->id]
        ])) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, 'Job Source already exists with same name.');
        }

        if (!$sourceManager->update($jobSource, $details)) {
            abort('204', 'Could not update Source.');
        }

        return $this->sendSuccessResponse([], 'Successfully updated Source.');
    }
}
