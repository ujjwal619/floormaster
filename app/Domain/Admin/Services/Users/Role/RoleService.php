<?php

namespace App\Domain\Admin\Services\Users\Role;

use App\Data\Entities\Models\User\Role;
use App\Data\Repositories\User\Role\RoleRepository;
use App\Domain\Admin\Resources\Roles\RolesResource;

/**
 * Class RoleService
 * @property Role role
 * @package App\Domain\Admin\Services\Users\Role
 */
class RoleService
{
    /**
     * @var Role
     */
    protected $roleRepository;

    /**
     * RoleService constructor.
     * @param RoleRepository $roleRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Get the paginated roles for data table.
     * @param array $filters
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getPaginatedRolesForTable(array $filters)
    {
        $roles = $this->roleRepository->getPaginatedRolesWith($filters);

        return RolesResource::collection($roles);
    }

    /**
     * @param int $roleId
     * @return mixed
     */
    public function findById(int $roleId): Role
    {
        return $this->roleRepository->find($roleId);
    }

    /**
     * Create new role from the form.
     * @param array $inputData
     * @return Role
     * @throws \Exception
     */
    public function create(array $inputData): Role
    {
        $inputData['guard_name'] = 'web';

        return $this->roleRepository->create($inputData);
    }

    /**
     * @param array $updateData
     * @param int   $roleId
     * @return bool
     * @throws \Exception
     */
    public function update(array $updateData, int $roleId): bool
    {
        return (bool)$this->roleRepository->update($updateData, $roleId);
    }

    /**
     * Delete the role with specific role id.
     * @param int $roleId
     * @return bool|int|null
     */
    public function destroy(int $roleId): bool
    {
        return (bool)$this->roleRepository->delete($roleId);
    }

}