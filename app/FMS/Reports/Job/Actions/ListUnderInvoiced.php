<?php

namespace App\FMS\Reports\Job\Actions;

use App\FMS\Reports\Job\Queries\UnderInvoicedQuery;
use App\Response\PaginationResource;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ListUnderInvoiced extends AdminController
{
    public function __invoke(Request $request, UnderInvoicedQuery $underInvoicedQuery)
    {
        $jobs = $underInvoicedQuery->run($request);
        
        return new PaginationResource($jobs);
    }
}
