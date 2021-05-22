<?php

namespace App\FMS\Supplier\Actions;

use App\FMS\Supplier\Models\Payable;
use App\StartUp\BaseClasses\Controller\AdminController;

class ShowSupplierPayable extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:payables']);
    }

    public function __invoke(Payable $payable)
    {
        $payableData = $payable->load(['supplier', 'levyAccount', 'costAccount', 'liabilityAccount', 'job']);
        $payableData->trading_terms = (object) $payableData->trading_terms;
        $payableData->credit_request = (object) $payableData->credit_request;

        return $this->sendSuccessResponse($payableData->toArray());
    }
}
