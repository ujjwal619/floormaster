<?php

namespace App\FMS\CashBook\Actions;

use App\FMS\CashBook\Models\CashBook;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class UpdateCashBook extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:cash.book.edit.entries']);
    }

    public function __invoke(CashBook $cashBook, Request $request)
    {
        $details = $request->all();
        $filteredDetails = [];

        $filteredDetails['presented_date'] = array_get($details, 'presented_date');
        $filteredDetails['payment_type'] = array_get($details, 'payment_type');
        $filteredDetails['job_id'] = array_get($details, 'job_id');

        if (!$cashBook->fill($filteredDetails)->save()) {
            abort('204', 'Could not update cash book.');
        }

        return $this->sendSuccessResponse([], 'Cash Book updated successfully.');
    }
}
