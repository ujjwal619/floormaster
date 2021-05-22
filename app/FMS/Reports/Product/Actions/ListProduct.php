<?php

namespace App\FMS\Reports\Product\Actions;

use App\FMS\Reports\Product\Queries\ProductQuery;
use App\Response\PaginationResource;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ListProduct extends AdminController
{
    public function __invoke(Request $request, ProductQuery $productQuery)
    {
        $jobs = $productQuery->run($request);

        return new PaginationResource($jobs);
    }
}
