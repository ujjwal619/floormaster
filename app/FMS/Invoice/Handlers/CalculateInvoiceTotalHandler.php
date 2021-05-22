<?php

namespace App\FMS\Invoice\Handlers;

use App\FMS\Invoice\Events\CalculateInvoiceTotal;
use App\FMS\Job\Manager as JobManager;

class CalculateInvoiceTotalHandler
{

    public function __construct(
        
    ) {
          
    }

    public function handle(CalculateInvoiceTotal $calculateStockTotal)
    {
        $invoice = $calculateStockTotal->invoice();
        $expenses = $invoice->expenses;
        $receipts = $invoice->receipts;
        $job = $invoice->job;
        $jobManager = app(JobManager::class);
        // dd($job, $jobManager);

        $totalExpenses = $expenses->reduce(function($carry, $expense) {
            return $carry + $expense->net_amount;
        }, 0);

        $totalReceipts = $receipts->reduce(function($carry, $receipt) {
            return $carry + $receipt->amount;
        }, 0);

        $invoice->fill([
            'total_receipts' => $totalReceipts,
            'total_expenses' => $totalExpenses,
            'balance_due' => $invoice->amount - $totalExpenses - $totalReceipts - $invoice->retention_amount,
        ])->save();

        $jobManager->calculateJobTotal($job);
    }
}
