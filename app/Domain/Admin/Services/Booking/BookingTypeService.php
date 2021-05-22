<?php

namespace App\Domain\Admin\Services\Booking;

use App\Data\Entities\Models\Booking\BookingType;
use App\Data\Repositories\Booking\BookingTypeRepository;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class BookingTypeService
 * @package App\Domain\Admin\Services\Booking
 */
class BookingTypeService
{
    /**
     * @var BookingTypeRepository
     */
    protected $bookingTypeRepository;

    /**
     * BookingTypeService constructor.
     * @param BookingTypeRepository $bookingTypeRepository
     */
    public function __construct(BookingTypeRepository $bookingTypeRepository)
    {
        $this->bookingTypeRepository = $bookingTypeRepository;
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->bookingTypeRepository->all([
            'id', 'name', 'numeric_column_headings', 'text_column_heading', 'default_day_limit'
        ]);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->bookingTypeRepository->find($id);
    }

    /**
     * @param array $details
     * @return mixed
     */
    public function store(array $details)
    {
        return $this->bookingTypeRepository->create($details);
    }

    /**
     * @param int $id
     * @param array $inputData
     * @return mixed
     */
    public function update(int $id, array $inputData)
    {
        return $this->bookingTypeRepository->update($inputData, $id);
    }

    /**
     * Find the latest id of the booking type.
     * @return mixed
     */
    public function findLatest()
    {
        return $this->bookingTypeRepository->getLatest();
    }

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id)
    {
        return $this->bookingTypeRepository->delete($id);
    }
}
