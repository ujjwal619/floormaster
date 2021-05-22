<?php

namespace App\Data\Repositories\Product\Category;

use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CategoryRepository
 * @package App\Data\Repositories\Product\Category
 */
interface CategoryRepository extends RepositoryInterface
{
    /**
     * Get the paginated customers with filter parameters.
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getPaginatedCategoriesWith(array $filters): LengthAwarePaginator;

    /**
     * Checks if the provided name is unique or not.
     * @param string $name
     * @return bool
     */
    public function nameExists(string $name): bool;
}