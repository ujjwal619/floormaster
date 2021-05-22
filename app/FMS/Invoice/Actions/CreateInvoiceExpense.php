<?php

namespace App\FMS\Invoice\Actions;

use App\Data\Entities\Models\Job\Invoice;
use App\FMS\Invoice\Events\CalculateInvoiceTotal;
use App\FMS\Job\Events\CalculateJobTotal;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class CreateInvoiceExpense extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:billing.access.edit.bills']);
    }

    public function __invoke(Invoice $invoice, Request $request)
    {
        $request->validate([
            'debit_date' => 'required|date',
            'net_amount' => 'required|numeric',
            'gl_code' => 'required|numeric'
        ]);

        $invoice->load('job');
        $job = $invoice->job;
        $details = $request->all();
        $details['site_id'] = $job->site_id;
        try {
            $expense = $invoice->expenses()->create($details);
            if (!empty($details['gst'])) {
                $gstDetails = $details;
                $gstDetails['net_amount'] = $details['gst'];
                $gstDetails['expense_id'] = $expense->id;
                $invoice->expenses()->create($gstDetails);
            }
            event(new CalculateInvoiceTotal($invoice));
            // event(new CalculateJobTotal($job));
        } catch (\Exception $exception) {
            return $this->sendError('Could not create expense.');
        }

        return $this->sendSuccessResponse([], 'Expense Created successfully.');
    }
}
