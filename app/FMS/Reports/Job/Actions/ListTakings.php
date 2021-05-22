<?php

namespace App\FMS\Reports\Job\Actions;

use App\FMS\Reports\Job\Queries\TakingQuery;
use App\Response\PaginationResource;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ListTakings extends AdminController
{
    public function __invoke(TakingQuery $takingQuery, Request $request)
    {
        return new PaginationResource($takingQuery->run($request));
    }
}
