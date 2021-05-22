<?php

namespace App\Domain\Admin\Controllers\Users;

use App\Domain\Admin\Requests\User\UsersRequest;
use App\Domain\Admin\Services\Users\UserService;
use App\Infrastructure\Helpers\SelectListHelper;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class UsersController
 * @package App\Domain\Admin\Controllers\Users
 */
class UsersController extends AdminController
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * UsersController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService      = $userService;
    }

    /**
     * Index page for users page.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.modules.users.index');
    }

    /**
     * @param string $status
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function getPaginatedUsers(string $status)
    {
        $filters = request()->merge(['status' => $status])->all();
        $users   = $this->userService->getPaginatedUsersForTable($filters);

        return $users;
    }

    /**
     * @param SelectListHelper $selectListHelper
     * @return string
     */
    public function create(SelectListHelper $selectListHelper)
    {
        $roles = $selectListHelper->getAllRolesNameAndIdForDropDown();

        return view('admin.modules.users.create', compact('roles'));
    }

    /**
     * @param UsersRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UsersRequest $request)
    {
        try {
            $this->userService->createUserWithRole($request->all());
        } catch (\Exception $exception) {
            logger()->error($exception);
            flash('Unable to create new user.', 'error');

            return $this->sendError('Unable to create new user.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully created new user.');
    }

    /**
     * Update the status of the user.
     * @param string $userId
     * @param string $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(string $userId, string $status)
    {
        try {
            $this->userService->changeStatus($userId, $status);
        } catch (\Exception $exception) {
            logger()->error($exception);

            return $this->sendError('Unable to update the status.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully changed the status of the user.');
    }

    /**
     * Display the details of the user.
     * @param string $userId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $userId)
    {
        $user          = $this->userService->findById($userId);
        $buttonDetails = getUserDetailsForDeleteButton($user);

        return view('admin.modules.users.show', compact('user', 'buttonDetails'));
    }

    /**
     * Load the form for editing the user details.
     * @param string           $userId
     * @param SelectListHelper $selectListHelper
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(string $userId, SelectListHelper $selectListHelper)
    {
        $user       = $this->userService->findById($userId);
        $user->role = $user->roles[0]->id;
        $roles      = $selectListHelper->getAllRolesNameAndIdForDropDown();

        return view('admin.modules.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the user.
     * @param string       $userId
     * @param UsersRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(string $userId, UsersRequest $request)
    {
        try {
            $this->userService->updateUser($request->all(), $userId);
        } catch (\Exception $exception) {
            logger()->error($exception);
            flash('Unable to update user.', 'error');

            return $this->sendError('Unable to update user.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully updated new user.');
    }

    /**
     * Displays the profile page of logged in user.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile()
    {
        $user = currentUser();

        return view('admin.modules.users.profile', compact('user'));
    }

    /**
     * Displays the edit-profile page of logged in user.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editProfile()
    {
        $user = currentUser();

        return view('admin.modules.users.edit-profile', compact('user'));
    }

    /**
     * Updates the profile logged in user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'full_name.first_name' => 'required',
            'full_name.last_name'  => 'required',
        ]);
        try {
            $this->userService->updateUser($request->all(), currentUser()->id);
        } catch (\Exception $exception) {
            logger()->error($exception);
            flash('Unable to update profile.', 'error');

            return $this->sendError('Unable to update profile.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully updated profile.');
    }

    /**
     * Changes password by Admin.
     *
     * @param         $userId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePasswordByAdmin($userId, Request $request)
    {
        $this->validate($request, ['password' => 'required|confirmed|min:6']);
        try {
            $this->userService->changePassword($userId, $request['password']);
        } catch (\Exception $exception) {
            logger()->error($exception);

            return $this->sendError('Something went wrong.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Password Changed.');
    }
}
