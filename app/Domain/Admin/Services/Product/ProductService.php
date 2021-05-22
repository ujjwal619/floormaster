<?php

namespace App\Domain\Admin\Services\Product;

use App\Data\Entities\Models\Product\Product;
use App\Data\Repositories\Product\ProductRepository;
use App\Data\Repositories\Product\ProductVariantRepository;
use App\Data\Repositories\Supplier\SupplierRepository;
use Illuminate\Support\Collection;

class ProductService
{
    private $productRepository;
    private $productVariantRepository;

    private $supplierRepository;

    public function __construct(
        ProductRepository $productRepository,
        ProductVariantRepository $productVariantRepository,
        SupplierRepository $supplierRepository
    ) {
        $this->productRepository = $productRepository;
        $this->productVariantRepository = $productVariantRepository;
        $this->supplierRepository = $supplierRepository;
    }

    public function store(array $details): Product
    {
        $supplier = $this->supplierRepository->find($details['supplier_id']);
        return $this->productRepository->save($supplier, $details);
    }

    public function getAll(int $bookingTypeId = null): Collection
    {
        return $this->productRepository->getAll($bookingTypeId);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->productRepository->with('productVariants')->find($id);
    }

    public function update(int $id, array $details)
    {
        return $this->productRepository->edit($id, $details);
    }

    /**
     * Find the latest id of the supplier.
     * @return Product
     */
    public function findLatest()
    {
        return $this->productRepository->getLatest();
    }

    public function findLatestStock()
    {
        return $this->productVariantRepository->getLatest();
    }

    public function delete(int $id)
    {
        return $this->productRepository->delete($id);
    }
}

