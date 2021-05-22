<?php

namespace App\FMS\Reports\Product\Actions;

use App\FMS\Reports\Product\Queries\ColourwaysQuery;
use App\Response\PaginationResource;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ListColourways extends AdminController
{
    public function __invoke(Request $request, ColourwaysQuery $colourwaysQuery)
    {
        $jobs = $colourwaysQuery->run($request);

        return new PaginationResource($jobs);
    }
}
