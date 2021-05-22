<?php

namespace App\FMS\SalesStaff\Actions;

use App\FMS\SalesStaff\Manager;
use App\FMS\SalesStaff\Requests\CreateRequest;
use App\FMS\Site\Models\Site;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Response;

class CreateSalesStaff extends AdminController
{
    public function __invoke(
        Site $site, 
        CreateRequest $request, 
        Manager $salesStaffManager
    ) {
        $details = $request->all();

        if ($salesStaffManager->findWhere([
            'site_id' => $site->id, 
            'name' => $details['name'],
        ])) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, 'Sales Staff already exists with same name.');
        }

        if (!$salesStaffManager->create($site->id, $details)) {
            abort('204', 'Could not create Sales Staff.');
        }

        return $this->sendSuccessResponse([], 'Sales Staff added successfully.');
    }
}
