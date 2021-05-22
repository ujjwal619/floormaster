<?php

namespace App\FMS\Remittance\Actions;

use App\FMS\Remittance\Manager;
use App\FMS\Remittance\Models\Remittance;
use App\FMS\Remittance\Requests\CreateRequest;
use App\StartUp\BaseClasses\Controller\AdminController;

class UpdateRemittance extends AdminController
{
    public function __invoke(Remittance $remittance, CreateRequest $request, Manager $remittanceManager)
    {
        if (!$remittance = $remittanceManager->update($remittance, $request->all())) {
            abort('204', 'Could not update Remittance.');
        }

        return $this->sendSuccessResponse($remittance->fresh(['supplier'])->toArray(), 'Remittance updated successfully.');
    }
}
