<?php

namespace App\Data\Repositories\Booking;

use App\Data\Entities\Models\Booking\Booking;
use App\Data\Entities\Models\Booking\BookingType;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface BookingRepository
 * @package App\Data\Repositories\Booking
 */
interface BookingRepository extends RepositoryInterface
{
    /**
     * @param BookingType $bookingType
     * @param array $details
     * @return mixed
     */
    public function save(BookingType $bookingType, array $details);

    /**
     * Get the latest booking.
     * @return Booking
     */
    public function getLatest(): Booking;

    /**
     * @param int|null $bookingType
     * @return mixed
     */
    public function getAll(int $bookingType = null);

    /**
     * @param string $jobId
     * @return mixed
     */
    public function getByJob(string $jobId);
}
