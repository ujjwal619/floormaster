<?php

namespace App\FMS\SalesStaff\Actions;

use App\FMS\SalesStaff\Manager;
use App\FMS\SalesStaff\Models\SalesStaff;
use App\FMS\SalesStaff\Requests\CreateRequest;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Response;

class UpdateSalesStaff extends AdminController
{
    public function __invoke(SalesStaff $salesStaff, CreateRequest $request, Manager $salesStaffManager)
    {
        $details = $request->all();

        if ($salesStaffManager->findWhere([
            'site_id' => $details['site_id'], 
            'name' => $details['name'],
            ['id' , '<>', $salesStaff->id]
        ])) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, 'Sales Staff already exists with same name.');
        }

        if (!$salesStaffManager->update($salesStaff, $details)) {
            abort('204', 'Could not update Sales Staff.');
        }

        return $this->sendSuccessResponse([], 'Sales Staff updated successfully.');
    }
}
