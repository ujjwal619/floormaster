<?php

namespace App\FMS\Remittance\Actions;

use App\FMS\Remittance\Manager;
use App\FMS\Remittance\Models\Remittance;
use App\FMS\Remittance\Requests\CreateItemRequest;
use App\StartUp\BaseClasses\Controller\AdminController;

class CreateRemittanceItem extends AdminController
{
    public function __invoke(Remittance $remittance, CreateItemRequest $request, Manager $remittanceManager)
    {
        if (!$remittanceManager->createItem($remittance, $request->all())) {
            abort('204', 'Could not create Remittance Item.');
        }

        return $this->sendSuccessResponse([], 'Remittance Item added successfully.');
    }
}
