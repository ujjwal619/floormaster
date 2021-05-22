<?php

namespace App\FMS\SalesStaff\Actions;

use App\FMS\SalesStaff\Models\SalesStaff;
use App\StartUp\BaseClasses\Controller\AdminController;

class DeleteSalesStaff extends AdminController
{
    public function __invoke(SalesStaff $salesStaff)
    {
        if (!$salesStaff->delete()) {
            abort('204', 'Could not delete Sales Staff.');
        }

        return $this->sendSuccessResponse([], 'Sales Staff deleted successfully.');
    }
}
