<?php

namespace App\Domain\Admin\Controllers\Users\Permissions;

use App\Domain\Admin\Services\Users\Permission\PermissionService;
use App\Infrastructure\Helpers\SelectListHelper;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class PermissionsController
 * @package App\Domain\Admin\Controllers\Module
 */
class PermissionsController extends AdminController
{
    /**
     * @var PermissionService
     */
    protected $permissionService;
    /**
     * @var SelectListHelper
     */
    protected $selectListHelper;

    /**
     * ModulesController constructor.
     * @param PermissionService $permissionService
     * @param SelectListHelper  $selectListHelper
     */
    public function __construct(PermissionService $permissionService, SelectListHelper $selectListHelper)
    {
        $this->permissionService = $permissionService;
        $this->selectListHelper  = $selectListHelper;
    }

    public function showRolesAndPermissions()
    {
        $roles       = $this->selectListHelper->getAllRoles();
        $permissions = $this->selectListHelper->getAllPermissions();

        return view('admin.modules.permission.assignRolesAndPermissions', compact('roles', 'permissions'));
    }

    /**
     * Displays the list of modules.
     */
    public function index()
    {
        return view('admin.modules.permission.index');
    }

    /**
     * Returns the paginated list of permissions for data table.
     */
    public function getPaginatedPermissions()
    {
        $permissions = $this->permissionService->getPaginatedPermissionsForTable(request()->all());

        return $permissions;
    }

    /**
     * Displays the form for creating a module.
     */
    public function create()
    {
        return view('admin.modules.permission.create');
    }

    /**
     * Stores the module in database.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'  => 'required',
            'title' => 'required',
        ]);
        try {
            $this->permissionService->createPermission($request->only('name', 'title'));
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('Unable to create new permission.', 'error');

            return $this->sendError('Unable to create new permission.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully created new permission.');
    }

    public function togglePermission($permissionId, $roleId)
    {
        try {
            $this->permissionService->togglePermission((int)$permissionId, (int)$roleId);
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('Something went wrong.', 'error');

            return $this->sendError('Something went wrong.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully changed permission.');
    }

    /**
     * Displays the form for editing a permission.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $permission = $this->permissionService->findById($id);

        return view('admin.modules.permission.edit', compact('permission'));
    }

    /**
     * Updates the module in the database.
     *
     * @param string  $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(string $id, Request $request)
    {
        $this->validate($request, [
            'name'  => 'required',
            'title' => 'required',
        ]);
        try {
            $this->permissionService->update($id, $request->only('title'));
        } catch (ModelNotFoundException $exception) {
            return $this->sendError('Permission not found.', Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());

            flash('Unable to update Permission.', 'error');

            return $this->sendError('Unable to update Permission.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully updated Permission.');
    }

    /**
     * Deletes a module.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        try {
            $this->permissionService->delete($id);
        } catch (ModelNotFoundException $exception) {
            return $this->sendError('Permission not found.', Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
        }

        return $this->sendSuccessResponse([], 'Permission deleted successfully!');
    }
}
