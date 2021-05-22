<?php

namespace App\FMS\Supplier\Actions;

use App\FMS\Supplier\Models\Payable;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class UpdateSupplierPayable extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:payables.edit']);
    }

    public function __invoke(Payable $payable, Request $request)
    {
        $details = $request->all();

        $request->validate([
            'invoice_date' => 'date|required',
            'goods' => 'numeric',
            'freight' => 'numeric',
            'levy' => 'numeric',
            'gst' => 'numeric',
        ]);

        $details['expected_amount'] = array_get($details, 'goods', 0) + array_get($details, 'freight', 0) + array_get($details, 'levy', 0) + array_get($details, 'gst', 0);
        $details['adjustment'] = $details['expected_amount'] - $payable->invoice_amount;

        if (!$payable->fill($details)->save()) {
            abort('204', 'Could not update Payable.');
        }

        return $this->sendSuccessResponse([], 'Payable updated successfully.');
    }
}
