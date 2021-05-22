<?php

namespace App\Domain\Admin\Controllers\Users;

use App\Domain\Admin\Requests\User\Role\RoleRequest;
use App\Domain\Admin\Services\Users\Role\RoleService;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

/**
 * Class RolesController
 * @package App\Domain\Admin\Controllers\Users
 */
class RolesController extends AdminController
{
    /**
     * @var RoleService
     */
    private $roleService;

    /**
     * RolesController constructor.
     * @param RoleService $roleService
     */
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * @return JsonResource
     */
    public function getPaginatedRoles()
    {
        return $this->roleService->getPaginatedRolesForTable(request()->all());
    }

    /**
     * List out the index page for the roles module.
     */
    public function index()
    {
        return view('admin.modules.roles.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.modules.roles.create');
    }

    /**
     * Create new role after validation.
     * @param RoleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RoleRequest $request)
    {
        try {
            $this->roleService->create($request->all());

            flash('Successfully added new role.', 'success');
        } catch (\Exception $exception) {
            logger()->error($exception);
            flash('Unable to create new role.', 'error');
        }

        return redirect()->route('admin.roles.index');
    }

    /**
     * Edit the role.
     * @param $roleId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($roleId)
    {
        $role = $this->roleService->findById((int)$roleId);

        return view('admin.modules.roles.edit', compact('role'));
    }

    /**
     * @param RoleRequest $request
     * @param             $roleId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RoleRequest $request, $roleId)
    {
        try {
            $this->roleService->update($request->all(), (int)$roleId);

            flash('Successfully added new role.', 'success');
        } catch (\Exception $exception) {
            logger()->error($exception);
            flash('Unable to update role.', 'error');
        }

        return redirect()->route('admin.roles.index');
    }

    /**
     * @param $roleId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($roleId)
    {
        try {
            $this->roleService->destroy((int)$roleId);
        } catch (\Exception $exception) {
            logger()->error($exception);

            return $this->sendError('Unable to delete the role', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully deleted the role.');
    }
}
