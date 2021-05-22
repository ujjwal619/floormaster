<?php

namespace App\FMS\Booking;

use App\Data\Entities\Models\Booking\Booking;
use App\Data\Entities\Models\Booking\BookingType;

class Manager
{
    private $booking;
    private $bookingType;

    public function __construct(Booking $booking, BookingType $bookingType)
    {
        $this->booking = $booking;
        $this->bookingType = $bookingType;
    }

    public function findBookingTypeWhere(array $conditions = [])
    {
        return $this->bookingType->where($conditions)->first();
    }
}
