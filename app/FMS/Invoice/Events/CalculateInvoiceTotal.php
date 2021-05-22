<?php

namespace App\FMS\Invoice\Events;

use App\Data\Entities\Models\Job\Invoice;

class CalculateInvoiceTotal
{
    public $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice->load(['receipts', 'expenses', 'job']);
    }

    public function invoice()
    {
        return $this->invoice;
    }
}
