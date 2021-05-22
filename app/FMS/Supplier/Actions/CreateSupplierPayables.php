<?php

namespace App\FMS\Supplier\Actions;

use App\Data\Entities\Models\Supplier\Supplier;
use App\FMS\Supplier\Manager;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class CreateSupplierPayables extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:payables.add']);
    }

    public function __invoke(Supplier $supplier, Request $request, Manager $supplierManager)
    {
        $request->validate([
            'invoice_date' => 'date|required',
            'invoice_amount' => 'numeric|required',
            'goods' => 'numeric',
            'freight' => 'numeric',
            'levy' => 'numeric',
            'gst' => 'numeric',
        ]);

        $details = $request->all();

        if (!$payable = $supplierManager->savePayable($supplier, $details)) {
            abort('204', 'Could not create Payable.');
        }

        return $this->sendSuccessResponse($payable->toArray(), 'Payable added successfully.');
    }
}
