<?php

namespace App\FMS\Job\Actions;

use App\Data\Entities\Models\Job\Invoice;
use App\Data\Entities\Models\Job\Job;
use App\FMS\Invoice\Events\CalculateInvoiceTotal;
use App\FMS\Job\Events\MITAllocated;
use App\FMS\Job\Manager;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class AllocateMIT extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:job.access.allocate.mit']);
    }

    public function __invoke(
        Job $job, 
        Invoice $invoice, 
        Request $request,
        Manager $jobManager
    ) {
        $this->validate($request, [
            'mit_payments' => 'required|array',
        ]);

        $details = $request->all();
        foreach($details['mit_payments'] as $receiptId) {
            $receipt = $jobManager->findReceipt($receiptId);
            $receipt->fill(['invoice_id' => $invoice->id])->save();
            $receipt = $receipt->fresh(['job.site']);

            event(new MITAllocated($receipt, $receipt->job));
            event(new CalculateInvoiceTotal($invoice));
        }

        return $this->sendSuccessResponse([], 'Successfully allocated MIT.');
    }
}
