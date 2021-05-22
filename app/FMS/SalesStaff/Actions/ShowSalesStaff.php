<?php

namespace App\FMS\SalesStaff\Actions;

use App\FMS\SalesStaff\Models\SalesStaff;
use App\FMS\Site\Models\Site;
use App\StartUp\BaseClasses\Controller\AdminController;

class ShowSalesStaff extends AdminController
{
    public function __invoke(SalesStaff $salesStaff)
    {
        return $this->sendSuccessResponse($salesStaff->toArray());
    }
}
