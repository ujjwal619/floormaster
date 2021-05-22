<?php

namespace App\Domain\Admin\Services\Users;

use App\Constants\StatusType;
use App\Data\Entities\Models\User\User;
use App\Data\Repositories\User\{UserRepository};
use App\Domain\Admin\Resources\Users\UsersResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * Class UserService
 * @package App\Domain\Admin\Services\Users
 */
class UserService
{
    /**
     * @var array
     */
    protected $updateActions = [
        'activate'   => StatusType::VERIFIED,
        'deactivate' => StatusType::DEACTIVATED,
    ];
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $filters
     * @return JsonResource
     */
    public function getPaginatedUsersForTable(array $filters): JsonResource
    {
        $users = $this->userRepository->getPaginatedUsersWith($filters);

        return UsersResource::collection($users);
    }

    /**
     * @param array $inputData
     * @return User
     * @throws \Exception
     */
    public function createUserWithRole(array $inputData)
    {
        return $this->userRepository->createUserWithRole($inputData);
    }

    /**
     * Update the status of the user.
     * @param string $userId
     * @param string $status
     * @return mixed
     */
    public function changeStatus(string $userId, string $status): bool
    {
        return (bool)$this->userRepository->update(['status' => array_get($this->updateActions, $status)], $userId);
    }

    /**
     * Find the user by id.
     * @param string $userId
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findById(string $userId): User
    {
        return $this->userRepository->find($userId, ['id', 'full_name', 'email', 'status', 'username']);
    }

    /**
     * Update the user details.
     * @param array  $updateData
     * @param string $userId
     * @return bool
     */
    public function updateUser(array $updateData, string $userId)
    {
        unset($updateData['email'], $updateData['username']);

        return (bool)$this->userRepository->updateUserWithRole($updateData, $userId);
    }

    /**
     * @param string $role
     * @return \Illuminate\Support\Collection
     */
    public function getUsersByRole(string $role)
    {
        return $this->userRepository->getUsersByRole($role);
    }

    /**
     * Changes the password if the current logged in user is user.
     *
     * @param string $userId
     * @param string $password
     * @return User
     */
    public function changePassword(string $userId, string $password): User
    {
        return $this->userRepository->changePassword($userId, $password);
    }

    /**
     * Get all the users.
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->userRepository->all();
    }
}
