<?php

namespace App\FMS\Invoice\Actions;

use App\Data\Entities\Models\Job\Invoice;
use App\StartUp\BaseClasses\Controller\AdminController;

class ShowInvoice extends AdminController
{
    public function __invoke(Invoice $invoice)
    {
        $invoice->load('job.primarySalesPerson', 'job.site', 'job.salesCode', 'receipts', 'expenses');

        return $this->sendSuccessResponse($invoice->toArray());
    }
}
