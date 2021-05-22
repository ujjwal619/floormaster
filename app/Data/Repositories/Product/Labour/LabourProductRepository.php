<?php

namespace App\Data\Repositories\Product\Labour;

use App\Data\Entities\Models\Product\LabourProduct;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface LabourProductRepository
 * @package App\Data\Repositories\Product\Labour
 */
interface LabourProductRepository extends RepositoryInterface
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
     * @return LabourProduct
     */
    public function createProductWithVariants(array $inputData): LabourProduct;

    /**
     * Update a product with variant.
     *
     * @param array $updateData
     * @param int   $productId
     * @return LabourProduct
     */
    public function updateProductWithVariants(array $updateData, int $productId): LabourProduct;

    /**
     * Deletes a product type with its variants.
     *
     * @param int $productId
     * @return bool
     */
    public function deleteProductWithVariants(int $productId);
}
