<?php

namespace App\Console\Commands;

use App\Data\Entities\Models\Job\Invoice;
use App\Data\Entities\Models\Job\Job;
use Illuminate\Console\Command;

class ConvertStringValuesToNumericInJobInvoiceTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convertStringFromJobInvoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert string values to numeric in job invoice table.';

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
        $jobInvoices = Invoice::all();
        $jobInvoices->map(function (Invoice $jobInvoice) {
            $amount = round($jobInvoice->amount);
            if(preg_match("/^[0-9,]+$/", $amount)) {
                $a = str_replace(',', '', $amount);
                $jobInvoice->fill([
                    'amount' => (int) $a
                ])->save();
            }
        });

        dump('Successful');
    }
}
