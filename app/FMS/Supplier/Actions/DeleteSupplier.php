<?php

namespace App\FMS\Supplier\Actions;

use App\Data\Entities\Models\Supplier\Supplier;
use App\StartUp\BaseClasses\Controller\AdminController;

class DeleteSupplier extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:suppliers.delete']);
    }

    public function __invoke(Supplier $supplier)
    {
        if (
            !empty($supplier->remittances->toArray()) ||
            !empty($supplier->supplierProducts->toArray()) ||
            !empty($supplier->payables->toArray())
        ) {
            return $this->sendError('Could not delete Supplier.');
        }

        if (!$supplier->delete()) {
            return $this->sendError('Could not delete Supplier.');
        }

        return $this->sendSuccessResponse([], 'Supplier deleted successfully.');
    }
}
