<?php

namespace App\FMS\Contractor\Actions;

use App\Data\Entities\Models\Contractor\Contractor;
use App\StartUp\BaseClasses\Controller\AdminController;

class RemoveContractorPayments extends AdminController
{
    public function __invoke(Contractor $contractor)
    {
        $contractor->payments()->delete();

        return $this->sendSuccessResponse([], 'Successfully deleted contractor payments.');
    }
}
