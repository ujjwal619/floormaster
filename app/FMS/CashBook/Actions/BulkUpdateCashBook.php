<?php

namespace App\FMS\CashBook\Actions;

use App\FMS\CashBook\Manager;
use App\FMS\CashBook\Models\CashBook;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class BulkUpdateCashBook extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:cash.book.edit.entries']);
    }

    public function __invoke(Request $request, Manager $cashBookManager)
    {
        $details = $request->all();

        $this->validate($request, [
            'cash_books' => 'required|array',
            'cash_books.*.id' => 'required',
            'cash_books.*.presented_date' => 'required|date',
        ]);

        collect($details['cash_books'])->map(function($cashBookDetail) use ($cashBookManager) {
            $cashBook = $cashBookManager->findById($cashBookDetail['id']);
            if ($cashBook) {
                $cashBook->fill(['presented_date' => $cashBookDetail['presented_date']])->save();
            }
        });

        return $this->sendSuccessResponse([], 'Cash Book updated successfully.');
    }
}
