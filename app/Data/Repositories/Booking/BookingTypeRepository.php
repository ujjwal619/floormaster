<?php

namespace App\Data\Repositories\Booking;

use Prettus\Repository\Contracts\RepositoryInterface;

interface BookingTypeRepository extends RepositoryInterface
{
    /**
     * Get the latest booking.
     * @return mixed
     */
    public function getLatest();
}
