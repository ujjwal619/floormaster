<?php

namespace App\Console\Commands;

use App\Data\Entities\Models\Job\Invoice;
use App\Data\Entities\Models\Job\Job;
use App\FMS\Invoice\Events\CalculateInvoiceTotal as EventsCalculateInvoiceTotal;
use App\FMS\Job\Manager;
use Illuminate\Console\Command;

class CalculateInvoiceTotal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculateInvoiceTotal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate Invoice Total.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $invoices = Invoice::all();
        $invoices->map(function($invoice) {
            event(new EventsCalculateInvoiceTotal($invoice));
        });

        dump('Successful');
    }
}
