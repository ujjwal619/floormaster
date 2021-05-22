<?php

namespace App\FMS\Job\Actions;

use App\FMS\Reports\Job\Queries\WorkInProgressQuery;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ListWorkInProgress extends AdminController
{
    public function __invoke(
        Request $request, 
        WorkInProgressQuery $workInProgressQuery
    ) {
        $data = $workInProgressQuery->all($request);

        return $this->sendSuccessResponse($data->toArray());
    }
}
