<?php

namespace App\Data\Repositories\User\Role;

use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface RoleRepository
 * @package App\Data\Repositories\User\Role
 */
interface RoleRepository extends RepositoryInterface
{
    /**
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getPaginatedRolesWith(array $filters): LengthAwarePaginator;
}
