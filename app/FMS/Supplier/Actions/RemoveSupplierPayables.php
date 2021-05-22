<?php

namespace App\FMS\Supplier\Actions;

use App\Data\Entities\Models\Supplier\Supplier;
use App\StartUp\BaseClasses\Controller\AdminController;

class RemoveSupplierPayables extends AdminController
{
    public function __invoke(Supplier $supplier)
    {
        $supplier->payables()->delete();

        return $this->sendSuccessResponse([], 'Successfully deleted suppliers payables.');
    }
}
