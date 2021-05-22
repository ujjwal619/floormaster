<?php

namespace App\FMS\Reports\Job\Actions;

use App\FMS\Reports\Job\Queries\MITQuery;
use App\Response\PaginationResource;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ListMIT extends AdminController
{
    public function __invoke(MITQuery $mITQuery, Request $request)
    {
        return new PaginationResource($mITQuery->run($request));
    }
}
