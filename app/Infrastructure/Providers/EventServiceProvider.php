<?php

namespace App\Infrastructure\Providers;

use App\FMS\CashBook\Events\CashBookCreated;
use App\FMS\CashBook\Handlers\CashBookCreatedHandler;
use App\FMS\Contractor\Events\PayableCreated as ContractorPayableCreated;
use App\FMS\Contractor\Handlers\PayableCreatedHandler as ContractorPayableCreatedHandler;
use App\FMS\Invoice\Events\CalculateInvoiceTotal;
use App\FMS\Invoice\Handlers\CalculateInvoiceTotalHandler;
use App\FMS\Job\Events\CalculateJobTotal;
use App\FMS\Job\Events\InvoiceCreated;
use App\FMS\Job\Events\MITAllocated;
use App\FMS\Job\Events\ReceiptCreated;
use App\FMS\Job\Events\ReceiptDeleted;
use App\FMS\Job\Handlers\CalculateJobTotalHandler;
use App\FMS\Job\Handlers\InvoiceCreatedHandler;
use App\FMS\Job\Handlers\MITAllocatedHandler;
use App\FMS\Job\Handlers\ReceiptCreatedHandler;
use App\FMS\Job\Handlers\ReceiptDeletedHandler;
use App\FMS\Remittance\Events\PaidToContractor;
use App\FMS\Remittance\Events\PaidToSupplier;
use App\FMS\Remittance\Handlers\PaidToContractorHandler;
use App\FMS\Remittance\Handlers\PaidToSupplierHandler;
use App\FMS\Stock\Events\AllocationDispatched;
use App\FMS\Stock\Events\CalculateStockTotal;
use App\FMS\Stock\Events\FutureStockInvoiced;
use App\FMS\Stock\Events\FutureStockReceived;
use App\FMS\Stock\Handlers\AllocationDispatchedHandler;
use App\FMS\Stock\Handlers\CalculateStockTotalHandler;
use App\FMS\Stock\Handlers\FutureStockInvoicedHandler;
use App\FMS\Stock\Handlers\FutureStockReceivedHandler;
use App\FMS\Supplier\Events\PayableCreated;
use App\FMS\Supplier\Events\PayableDeleted;
use App\FMS\Supplier\Handlers\PayableCreatedHandler;
use App\FMS\Supplier\Handlers\PayableDeletedHandler;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * Class EventServiceProvider
 * @package App\Infrastructure\Providers
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        ReceiptCreated::class => [
            ReceiptCreatedHandler::class
        ],
        ReceiptDeleted::class => [
            ReceiptDeletedHandler::class
        ],
        InvoiceCreated::class => [
            InvoiceCreatedHandler::class
        ],
        MITAllocated::class => [
            MITAllocatedHandler::class
        ],
        PaidToSupplier::class => [
            PaidToSupplierHandler::class
        ],
        PayableCreated::class => [
            PayableCreatedHandler::class
        ],
        CalculateStockTotal::class => [
            CalculateStockTotalHandler::class
        ],
        PayableDeleted::class => [
            PayableDeletedHandler::class
        ],
        ContractorPayableCreated::class => [
            ContractorPayableCreatedHandler::class
        ],
        PaidToContractor::class => [
            PaidToContractorHandler::class
        ],
        CalculateInvoiceTotal::class => [
            CalculateInvoiceTotalHandler::class
        ],
        FutureStockReceived::class => [
            FutureStockReceivedHandler::class
        ],
        FutureStockInvoiced::class => [
            FutureStockInvoicedHandler::class
        ],
        AllocationDispatched::class => [
            AllocationDispatchedHandler::class
        ],
        CashBookCreated::class => [
            CashBookCreatedHandler::class
        ],
        CalculateJobTotal::class => [
            CalculateJobTotalHandler::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
