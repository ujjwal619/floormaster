<?php

namespace App\FMS\Reports\Job\Actions;

use App\FMS\Reports\Job\Queries\BillingQuery;
use App\Response\PaginationResource;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ListBilling extends AdminController
{
    public function __invoke(BillingQuery $billingQuery, Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        return new PaginationResource($billingQuery->run($request));
    }
}
