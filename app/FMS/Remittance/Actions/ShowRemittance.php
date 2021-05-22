<?php

namespace App\FMS\Remittance\Actions;

use App\FMS\Remittance\Models\Remittance;
use App\StartUp\BaseClasses\Controller\AdminController;

class ShowRemittance extends AdminController
{
    public function __invoke(Remittance $remittance)
    {
        return $this->sendSuccessResponse($remittance->fresh(['supplier', 'items', 'contractor', 'site'])->toArray());
    }
}
