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
interface ProductVariantRepository extends RepositoryInterface
{
    public function getLatest();
}
