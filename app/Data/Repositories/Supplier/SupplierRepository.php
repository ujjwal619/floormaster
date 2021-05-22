<?php

namespace App\Data\Repositories\Supplier;

use App\Data\Entities\Models\Supplier\Supplier;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface SupplierRepository
 * @package App\Data\Repositories\Customer
 */
interface SupplierRepository extends RepositoryInterface
{
    /**
     * Get the paginated customers with filter parameters.
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getPaginatedSuppliersWith(array $filters): LengthAwarePaginator;

    /**
     * Creates a supplier with other data.
     *
     * @param $inputData
     * @return Supplier
     */
    public function createSupplierWithSalesAndSites(array $inputData): Supplier;

    /**
     * Updates a supplier with other data.
     *
     * @param $updateData
     * @param $supplierId
     * @return Supplier
     */
    public function updateSupplierWithSalesAndSites(array $updateData, int $supplierId);

    /**
     * Get the latest supplier.
     * @return Supplier
     */
    public function getLatest(): Supplier;
}
