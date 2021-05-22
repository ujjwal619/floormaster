<?php

namespace App\Console\Commands;

use App\Data\Entities\Models\Booking\Booking;
use Illuminate\Console\Command;

class PutPreviousBookingsInSite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'putPreviousBookingsInSite';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Put previous bookings in site.';

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
        $bookings = Booking::with(['job'])->get();
        $bookings->map(function (Booking $booking) {
            $booking->fill([
                'site_id' => $booking->job ? $booking->job->site_id : $booking->site_id
            ])->save();
        });

        dump('Successful');
    }
}
