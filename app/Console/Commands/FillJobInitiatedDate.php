<?php

namespace App\Console\Commands;

use App\Data\Entities\Models\Job\Job;
use App\FMS\Job\Manager;
use Illuminate\Console\Command;

class FillJobInitiatedDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fillJobInitiatedDate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill Job Initiated Date.';

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
        $jobManager = app(Manager::class);
        
        $jobs = Job::whereNull('quote_id')->get();
        $jobs->map(function (Job $job) use ($jobManager) {
            $job->fill(['initiation_date' => $job->quote_date])->save();
        });

        dump('Successful');
    }
}
