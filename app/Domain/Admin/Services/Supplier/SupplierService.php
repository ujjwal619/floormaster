<?php

namespace App\Domain\Admin\Services\Supplier;

use App\Data\Entities\Models\Supplier\Supplier;
use App\Data\Repositories\Supplier\SupplierRepository;
use App\Domain\Admin\Resources\Suppliers\SupplierResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * Class SupplierService
 * @package App\Domain\Admin\Services\Customers
 */
class SupplierService
{
    /**
     * @var SupplierRepository
     */
    protected $supplierRepository;

    /**
     * CustomerService constructor.
     * @param SupplierRepository $supplierRepository
     */
    public function __construct(SupplierRepository $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    /**
     * @param array $inputData
     * @return Supplier
     */
    public function create(array $inputData): Supplier
    {
        return $this->supplierRepository->create($inputData);
    }

    /**
     * Create new Supplier.
     * @param array $inputData
     * @return Supplier
     */
    public function createSupplier(array $inputData): Supplier
    {
        return $this->supplierRepository->createSupplierWithSalesAndSites($inputData);
    }

    /**
     * Get the paginated Suppliers with filters for data table.
     * @param array $filters
     * @return JsonResource
     */
    public function getPaginatedSuppliersForTable(array $filters): JsonResource
    {
        $customers = $this->supplierRepository->getPaginatedSuppliersWith($filters);

        return SupplierResource::collection($customers);
    }

    /**
     * Delete the Supplier.
     * @param int $supplierId
     * @return bool
     */
    public function delete(int $supplierId): bool
    {
        return (bool)$this->supplierRepository->delete($supplierId);
    }

    /**
     * Find customer by id.
     * @param int $supplierId
     * @return Supplier
     */
    public function findById(int $supplierId): Supplier
    {
        return $this->supplierRepository->find($supplierId);
    }

    /**
     * Update the instance of Supplier.
     * @param array $updateData
     * @param int   $supplierId
     * @return Supplier
     */
    public function update(array $updateData, int $supplierId): Supplier
    {
        return $this->supplierRepository->update($updateData, $supplierId);
    }

    /**
     * Find the latest id of the supplier.
     * @return Supplier
     */
    public function findLatest(): Supplier
    {
        return $this->supplierRepository->getLatest();
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->supplierRepository->all();
    }
}
