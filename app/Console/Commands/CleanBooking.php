<?php

namespace App\Console\Commands;

use App\Data\Entities\Models\Booking\Booking;
use App\Data\Entities\Models\Booking\BookingType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanBooking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanBooking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean Booking.';

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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        BookingType::truncate();
        Booking::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        dump('Successful');
    }
}
