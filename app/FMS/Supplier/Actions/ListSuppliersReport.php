<?php

namespace App\FMS\Supplier\Actions;

use App\FMS\Supplier\Queries\SupplierReport;
use App\FMS\Supplier\Resources\SupplierReportResource;
use App\Response\PaginationResource;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\Resource;

class ListSuppliersReport extends AdminController
{
    public function __invoke(Request $request, SupplierReport $supplierReport)
    {
        $suppliers = $supplierReport->run($request);

        // return new SupplierReportResource($suppliers);

        // return $this->sendSuccessResponse($suppliers->toArray());
        // return new JsonResponse($suppliers);

        return new PaginationResource($suppliers);
    }
}
