<?php

namespace App\Data\Repositories\Product\Material;

use App\Data\Entities\Models\Product\MaterialProduct;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface MaterialProductRepository
 * @package App\Data\Repositories\Product\Labour
 */
interface MaterialProductRepository extends RepositoryInterface
{
    /**
     * Get the paginated products with filter parameters.
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getPaginatedProductsWith(array $filters): LengthAwarePaginator;

    /**
     * Create a product with variant.
     *
     * @param array $inputData
     * @return mixed
     */
    public function createProductWithVariants(array $inputData): MaterialProduct;

    /**
     * Update a product with variant.
     *
     * @param array $updateData
     * @param int   $productId
     * @return MaterialProduct
     */
    public function updateProductWithVariants(array $updateData, int $productId): MaterialProduct;

    /**
     * Deletes a product type with its variants.
     *
     * @param int $productId
     * @return bool
     */
    public function deleteProductWithVariants(int $productId);
}
