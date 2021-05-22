<?php

namespace App\FMS\CashBook\Actions;

use App\FMS\CashBook\Events\CashBookCreated;
use App\FMS\CashBook\Manager;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class CreateCashBook extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:cash.book.add.entries']);
    }

    public function __invoke(Request $request, Manager $cashBookManager)
    {
        //TODO: date range validation 
        $request->validate([
            'type' => 'numeric|required',
            'payee' => 'required',
            'date' => 'date|required',
            'net_amount' => 'numeric|required',
            'payment_type' => 'required',
            'site_id' => 'numeric|required',
            'account_id' => 'numeric|required',
            'supplier_id' => 'numeric|required',
        ]);

        $details = $request->all();
        $details['presented_date'] = $details['date'];

        if (!$cashBook = $cashBookManager->createCashBook($request->all())) {
            abort('204', 'Could not create cash book.');
        }

        event(new CashBookCreated($cashBook));

        return $this->sendSuccessResponse([], 'Cash Book created successfully.');
    }
}
