<?php

namespace App\FMS\Reports\Job\Actions;

use App\FMS\Reports\Job\Queries\CommissionQuery;
use App\Response\PaginationResource;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\Resource;

class ListCommission extends AdminController
{
    public function __invoke(Request $request, CommissionQuery $commissionQuery)
    {
        $jobs = $commissionQuery->run($request);

        return new PaginationResource($jobs);
    }
}
