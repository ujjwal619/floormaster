<?php

namespace App\Domain\Admin\Services\Users\Permission;

use App\Data\Entities\Models\User\Permission;
use App\Data\Entities\Models\User\Role;
use App\Data\Repositories\User\Permission\PermissionRepository;
use App\Data\Repositories\User\Role\RoleRepository;
use App\Domain\Admin\Resources\Permissions\PermissionsResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ModuleService
 * @package App\Domain\Admin\Services\Module
 */
class PermissionService
{
    /**
     * @var PermissionRepository
     */
    protected $permissionRepository;
    /**
     * @var RoleRepository
     */
    protected $roleRepository;

    /**
     * ModuleService constructor.
     * @param PermissionRepository $permissionRepository
     * @param RoleRepository       $roleRepository
     */
    public function __construct(PermissionRepository $permissionRepository, RoleRepository $roleRepository)
    {
        $this->permissionRepository = $permissionRepository;
        $this->roleRepository       = $roleRepository;
    }

    /**
     * Returns the paginated modules for data table.
     *
     * @param array $filters
     * @return JsonResource
     */
    public function getPaginatedPermissionsForTable(array $filters): JsonResource
    {
        $modules = $this->permissionRepository->getPaginatedModulesWith($filters);

        return PermissionsResource::collection($modules);
    }

    /**
     * Stores a module in database.
     *
     * @param array $inputData
     * @return Permission
     * @throws \Exception
     */
    public function createPermission(array $inputData)
    {
        return $this->permissionRepository->create($inputData);
    }

    /**
     * Returns all the permissions.
     *
     * @return mixed
     */
    public function getAllPermissions()
    {
        return $this->permissionRepository->all();
    }

    /**
     * Toggles the permissions of a role.
     *
     * @param int $permissionId
     * @param int $roleId
     */
    public function togglePermission(int $permissionId, int $roleId)
    {
        $role       = $this->roleRepository->find($roleId);
        $permission = $this->findById($permissionId);
        if ($role->hasPermissionTo($permission)) {
            $role->revokePermissionTo($permission);
        } else {
            $role->givePermissionTo($permission);
        }
    }

    /**
     * Finds a permission by its id.
     *
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        return $this->permissionRepository->find($id);
    }

    /**
     * Updates the permission.
     *
     * @param string $id
     * @param array  $updateData
     */
    public function update(string $id, array $updateData)
    {
        $this->permissionRepository->update($updateData, $id);
    }

    /**
     * Deletes a permission.
     *
     * @param string $id
     */
    public function delete(string $id)
    {
        $this->permissionRepository->delete($id);
    }
}
