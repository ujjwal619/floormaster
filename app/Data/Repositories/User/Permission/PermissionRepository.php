<?php

namespace App\Data\Repositories\User\Permission;

use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface PermissionRepository
 * @package App\Data\Repositories\User\Permission
 */
interface PermissionRepository extends RepositoryInterface
{
    /**
     * Get the paginated users with filters.
     * @param array $filters
     * @return mixed
     */
    public function getPaginatedModulesWith(array $filters): LengthAwarePaginator;

}
