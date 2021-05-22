<?php

namespace App\Console\Commands;

use App\Data\Entities\Models\Booking\Booking;
use App\Data\Entities\Models\Job\JobMaterialSale;
use Illuminate\Console\Command;

class RecalculateJobMaterialWithDelivery extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recalculateJobMaterialWithDelivery';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate job material with devliery.';

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
        $jobMaterials = JobMaterialSale::with(['supplier'])->whereNotNull('product_id')->get();
        $jobMaterials->map(function (JobMaterialSale $jobMaterialSale) {
            $cost = $jobMaterialSale->unit * $jobMaterialSale->quantity;
            if ($jobMaterialSale->supplier->delivery) {
                $cost = $cost + $jobMaterialSale->supplier->delivery;
            }
            if ($jobMaterialSale->gst) {
                $cost = $cost + (($cost * $jobMaterialSale->gst) / 100);
            }
            if ($jobMaterialSale->levy) {
                $cost = $cost + (($cost * $jobMaterialSale->levy) / 100);
            }
            if ($jobMaterialSale->discount) {
                $cost = $cost - (($cost * $jobMaterialSale->discount) / 100);
            }
            $jobMaterialSale->fill([
                'total' => $cost
            ])->save();
        });

        dump('Successful');
    }
}
