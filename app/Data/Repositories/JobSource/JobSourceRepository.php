<?php

namespace App\Data\Repositories\JobSource;

use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface JobSourceRepository
 * @package App\Data\Repositories\JobSource
 */
interface JobSourceRepository extends RepositoryInterface
{
    /**
     * Get the paginated job sources with filters.
     * @param array $filters
     * @return mixed
     */
    public function getPaginatedJobSourcesWith(array $filters):  LengthAwarePaginator;
}
