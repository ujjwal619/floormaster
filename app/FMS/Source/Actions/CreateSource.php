<?php

namespace App\FMS\Source\Actions;

use App\Domain\Admin\Requests\JobSource\JobSourceRequest;
use App\FMS\Site\Models\Site;
use App\FMS\Source\Manager;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Response;

class CreateSource extends AdminController
{
    public function __invoke(
        Site $site, 
        JobSourceRequest $request, 
        Manager $sourceManager
    ) {
        $details = $request->all();
        $details['site_id'] = $site->id;

        if ($sourceManager->findWhere([
            'site_id' => $details['site_id'], 
            'title' => $details['title'],
        ])) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, 'Job Source already exists with same name.');
        }

        if (!$sourceManager->create($details)) {
            abort('204', 'Could not create Source.');
        }

        return $this->sendSuccessResponse([], 'Successfully created Source.');
    }
}
