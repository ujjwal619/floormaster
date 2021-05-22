<?php

namespace App\Data\Repositories\User;

use App\Data\Entities\Models\User\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface UserRepository
 * @package App\Data\Repositories\User
 */
interface UserRepository extends RepositoryInterface
{
    /**
     * Get the paginated users with filters.
     * @param array $filters
     * @return mixed
     */
    public function getPaginatedUsersWith(array $filters): LengthAwarePaginator;

    /**
     * Get users by role.
     * @param string $role
     * @return Collection
     */
    public function getUsersByRole(string $role): Collection;

    /**
     * Creates user with role.
     *
     * @param array $inputData
     * @return User
     */
    public function createUserWithRole(array $inputData): User;

    /**
     * Updates user with role.
     *
     * @param array  $updateData
     * @param string $userId
     * @return User
     */
    public function updateUserWithRole(array $updateData, string $userId): User;

    /**
     * Changes password of a user.
     *
     * @param string $userId
     * @param string $password
     * @return User
     */
    public function changePassword(string $userId, string $password): User;
}
