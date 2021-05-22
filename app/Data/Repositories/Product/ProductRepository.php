<?php

namespace App\Data\Repositories\Product;

use App\Data\Entities\Models\Booking\Booking;
use App\Data\Entities\Models\Product\Product;
use App\Data\Entities\Models\Supplier\Supplier;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface BookingRepository
 * @package App\Data\Repositories\Booking
 */
interface ProductRepository extends RepositoryInterface
{
    public function save(Supplier $supplier, array $details);

    /**
     * Get the latest product.
     * @return Product
     */
    public function getLatest();

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

    public function edit(int $id, array $details);
}
