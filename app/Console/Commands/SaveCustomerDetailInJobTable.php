<?php

namespace App\Console\Commands;

use App\Data\Entities\Models\Job\Job;
use Illuminate\Console\Command;

class SaveCustomerDetailInJobTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'saveCustomerDetailInJobTable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save customer detail in job table.';

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
        $jobs = Job::with(['customer'])->get();
        $jobs->map(function (Job $job) {
            $job->fill([
                'title' => $job->title,
                'firstname' => $job->firstname,
                'trading_name' => $job->trading_name,
                'address' => $job->address,
                'contact' => $job->phone,
            ])->save();
        });

        dump('Successful');
    }
}
