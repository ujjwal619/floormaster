<?php

namespace App\Domain\Admin\Controllers\Job;

use App\Domain\Admin\Services\Jobs\InvoiceService;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvoiceController extends AdminController
{
    private $service;

    public function __construct(InvoiceService $service)
    {
        $this->service = $service;
    }

    public function addReceipt(int $invoiceId, Request $request)
    {
        $this->validate($request, [
            'receipt_date'   => 'date',
            'amount'         => 'required|numeric',
        ]);

        $inputData = $request->all();

        try {
            $invoice = $this->service->find((int) $invoiceId);
            $invoice->receipts()->create($inputData);
        } catch (\Exception $exception) {
            $this->sendError('Unable to add new receipt.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $this->sendSuccessResponse([], 'Successfully added the receipt.');
    }
}
