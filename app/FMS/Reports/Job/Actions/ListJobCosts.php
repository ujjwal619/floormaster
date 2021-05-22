<?php

namespace App\FMS\Reports\Job\Actions;

use App\FMS\Reports\Job\Queries\JobCostsQuery;
use App\Response\PaginationResource;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ListJobCosts extends AdminController
{
    public function __invoke(Request $request, JobCostsQuery $jobCostsQuery)
    {
        $jobs = $jobCostsQuery->run($request);
        
        return new PaginationResource($jobs);
    }
}
