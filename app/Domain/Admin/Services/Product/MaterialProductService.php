<?php

namespace App\Domain\Admin\Services\Product;

use App\Data\Entities\Models\Product\MaterialProduct;
use App\Data\Repositories\Product\Material\MaterialProductRepository;
use App\Domain\Admin\Resources\Products\MaterialProductResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * Class MaterialProductService
 * @package App\Domain\Admin\Services\Product
 */
class MaterialProductService
{
    /**
     * @var MaterialProductRepository
     */
    protected $productRepository;

    /**
     * MaterialProductService constructor.
     * @param MaterialProductRepository $productRepository
     */
    public function __construct(MaterialProductRepository $productRepository)
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

        return MaterialProductResource::collection($products);
    }

    /**
     * Stores the new product in database.
     *
     * @param array $inputData
     * @return MaterialProduct
     */
    public function store(array $inputData): MaterialProduct
    {
        return $this->productRepository->createProductWithVariants($inputData);
    }

    /**
     * Updates the new product in database.
     *
     * @param int   $productId
     * @param array $updateData
     * @return MaterialProduct
     */
    public function update(int $productId, array $updateData): MaterialProduct
    {
        return $this->productRepository->updateProductWithVariants($updateData, $productId);
    }

    /**
     * Finds a product by its id.
     * @param int $productId
     * @return MaterialProduct
     */
    public function findById(int $productId): MaterialProduct
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
     * Returns all the material products.
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->productRepository->with('productVariants')->orderBy('is_featured', 'desc')->orderBy('name')->all();
    }
}
