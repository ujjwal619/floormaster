<?php

namespace App\Console\Commands;

use App\Data\Entities\Models\Job\Job;
use App\FMS\Job\Manager;
use Illuminate\Console\Command;

class CalculateJobTotal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculateJobTotal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate Job Total.';

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
        
        $jobs = Job::all();
        $jobs->map(function (Job $job) use ($jobManager) {
            $jobManager->calculateJobTotal($job);
        });

        dump('Successful');
    }
}
