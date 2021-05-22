<?php

namespace App\FMS\Remittance\Actions;

use App\FMS\Remittance\Models\Remittance;
use App\StartUp\BaseClasses\Controller\AdminController;

class DeleteRemittance extends AdminController
{
    public function __invoke(Remittance $remittance)
    {
        if (!$remittance->delete()) {
            return $this->sendError('Could not delete remittance.');
        }

        return $this->sendSuccessResponse([], 'Successfully Deleted remittance.');
    }
}
