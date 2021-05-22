<?php

namespace App\FMS\Remittance\Actions;

use App\FMS\Remittance\Manager;
use App\FMS\Remittance\Requests\CreateRequest;
use App\FMS\Site\Models\Site;
use App\StartUp\BaseClasses\Controller\AdminController;
use Exception;

class CreateRemittance extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:contractors.pay.contractor|suppliers.pay']);
    }

    public function __invoke(
        Site $site, 
        CreateRequest $request,
        Manager $remittanceManager
    ) {

        try {
            $remittance = $remittanceManager->create($site->id, $request->all());
        } catch(Exception $exception) {
            return $this->sendError($exception->getMessage());
        }

        return $this->sendSuccessResponse($remittance->fresh(['supplier'])->toArray(), 'Remittance added successfully.');
    }
}
