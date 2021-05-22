<?php

namespace App\Domain\Admin\Services\Booking;

use App\Data\Entities\Models\Booking\Booking;
use App\Data\Repositories\Booking\BookingRepository;
use App\Data\Repositories\Booking\BookingTypeRepository;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class BookingService
 * @package App\Domain\Admin\Services\Booking
 */
class BookingService
{
    /**
     * @var BookingRepository
     */
    protected $bookingRepository;

    /**
     * @var BookingTypeRepository
     */
    protected $bookingTypeRepository;

    /**
     * BookingService constructor.
     * @param BookingRepository $bookingRepository
     * @param BookingTypeRepository $bookingTypeRepository
     */
    public function __construct(
        BookingRepository $bookingRepository,
        BookingTypeRepository $bookingTypeRepository
    ) {
        $this->bookingRepository        = $bookingRepository;
        $this->bookingTypeRepository    = $bookingTypeRepository;
    }

    /**
     * @param array $details
     * @return Booking
     */
    public function store(array $details): Booking
    {
        $bookingType = $this->bookingTypeRepository->find($details['booking_type_id']);
        return $this->bookingRepository->save($bookingType, $details);
    }

    /**
     * @param int $id
     * @param array $inputData
     * @return mixed
     */
    public function update(int $id, array $inputData)
    {
        return $this->bookingRepository->update($inputData, $id);
    }

    /**
     * @param int|null $bookingTypeId
     * @return Collection
     */
    public function getAll(int $bookingTypeId = null): Collection
    {
        return $this->bookingRepository->getAll($bookingTypeId);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->bookingRepository->find($id);
    }

    /**
     * Find the latest id of the booking.
     * @return Booking
     */
    public function findLatest(): Booking
    {
        return $this->bookingRepository->getLatest();
    }

    /**
     * @param int $bookingId
     * @return int
     */
    public function delete(int $bookingId): int
    {
        return $this->bookingRepository->delete($bookingId);
    }

    /**
     * @param string $jobId
     * @return mixed
     */
    public function getByJob(string $jobId)
    {
        return $this->bookingRepository->getByJob($jobId);
    }
}
