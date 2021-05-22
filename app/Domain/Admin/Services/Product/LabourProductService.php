<?php

namespace App\Domain\Admin\Services\Product;

use App\Data\Entities\Models\Product\LabourProduct;
use App\Data\Repositories\Product\Labour\LabourProductRepository;
use App\Domain\Admin\Resources\Products\LabourProductResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * Class LabourProductService
 * @package App\Domain\Admin\Services\Product
 */
class LabourProductService
{
    /**
     * @var LabourProductRepository
     */
    protected $productRepository;

    /**
     * LabourProductService constructor.
     * @param LabourProductRepository $productRepository
     */
    public function __construct(LabourProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Returns the product data for data table.
     *
     * @param array $filters
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getPaginatedProductsForDataTable(array $filters): JsonResource
    {
        $products = $this->productRepository->getPaginatedProductsWith($filters);

        return LabourProductResource::collection($products);
    }

    /**
     * Stores the new product in database.
     *
     * @param array $inputData
     * @return LabourProduct
     */
    public function store(array $inputData): LabourProduct
    {
        return $this->productRepository->createProductWithVariants($inputData);
    }

    /**
     * Updates the new product in database.
     *
     * @param int   $productId
     * @param array $updateData
     * @return LabourProduct
     */
    public function update(int $productId, array $updateData): LabourProduct
    {
        return $this->productRepository->updateProductWithVariants($updateData, $productId);
    }

    /**
     * Finds a product by its id.
     * @param int $productId
     * @return LabourProduct
     */
    public function findById(int $productId): LabourProduct
    {
        return $this->productRepository->find($productId);
    }

    /**
     * Deletes a product.
     *
     * @param int $productId
     * @return bool
     */
    public function destroy(int $productId): bool
    {
        return $this->productRepository->deleteProductWithVariants($productId);
    }

    /**
     * Returns all the labour products.
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->productRepository->with('productVariants')->orderBy('is_featured', 'desc')->orderBy('name')->all();
    }
}
