<?php

namespace App\FMS\Job\Actions;

use App\Data\Entities\Models\Job\Invoice;
use App\Data\Entities\Models\Job\Job;
use App\FMS\Invoice\Events\CalculateInvoiceTotal;
use App\FMS\Job\Events\CalculateJobTotal;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class UpdateJobInvoice extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:billing.access.edit.bills']);
    }

    public function __invoke(Job $job, Invoice $invoice, Request $request)
    {
        $this->validate($request, [
            'date'           => 'required|date',
            'gst'           => 'required|numeric',
            'amount'         => 'required|numeric',
            'net_invoice'   => 'required|numeric'
        ]);

        $details = $request->all();
        $details['amount'] = ($details['net_invoice'] * $details['gst']) / 100;

        if (!$invoice->fill($request->all())->save()) {
            abort('204', 'Invoice not updated');
        }

        event(new CalculateInvoiceTotal($invoice));
        // event(new CalculateJobTotal($job));

        return $this->sendSuccessResponse([], 'Successfully updated invoice.');
    }
}
