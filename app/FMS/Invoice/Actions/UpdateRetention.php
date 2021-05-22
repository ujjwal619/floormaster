<?php

namespace App\FMS\Invoice\Actions;

use App\Data\Entities\Models\Job\Invoice;
use App\FMS\Invoice\Events\CalculateInvoiceTotal;
use App\FMS\Job\Events\CalculateJobTotal;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class UpdateRetention extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:billing.access.edit.bills']);
    }
    
    public function __invoke(Invoice $invoice, Request $request)
    {
//        $request->validate([
//            'retention_release_date' => 'date',
//            'retention_amount' => 'numeric'
//        ]);

        $details = $request->all('retention_amount', 'retention_release_date');
        $invoice->load('job');
        $job = $invoice->job;

        $invoice->fill($details)->save();

        event(new CalculateInvoiceTotal($invoice));
        // event(new CalculateJobTotal($job));

        return $this->sendSuccessResponse($invoice->toArray());
    }
}
