<?php

namespace App\FMS\Reports\Job\Actions;

use App\FMS\Reports\Job\Queries\WorkInProgressQuery;
use App\Response\PaginationResource;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ListWorkInProgress extends AdminController
{
    public function __invoke(Request $request, WorkInProgressQuery $workInProgressQuery)
    {
        $jobs = $workInProgressQuery->run($request);
        
        return new PaginationResource($jobs);
    }
}
