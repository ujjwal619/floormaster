<?php

namespace App\Data\Repositories\User;

use App\Constants\StatusType;
use App\Data\Entities\Models\User\User;
use App\StartUp\BaseClasses\Repository\BaseRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Database\DatabaseManager;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Class UserEloquentRepository
 * @package App\Data\Repositories\User
 */
class UserEloquentRepository extends BaseRepository implements UserRepository
{
    /**
     * @var DatabaseManager
     */
    protected $databaseManager;

    /**
     * UserEloquentRepository constructor.
     * @param Application     $app
     * @param DatabaseManager $databaseManager
     */
    public function __construct(Application $app, DatabaseManager $databaseManager)
    {
        parent::__construct($app);
        $this->databaseManager = $databaseManager;
    }

    /**
     * @var array
     */
    protected $filterFields = [
        'id'   => 'id',
        'name' => 'full_name->first_name',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Get the paginated users with filters.
     * @param $filters
     * @return mixed
     */
    public function getPaginatedUsersWith(array $filters): LengthAwarePaginator
    {
        $sortField = array_get($this->filterFields, $filters['column']) ?? $filters['column'];
        if ($filters['status'] === 'inactive') {
            $query = $this->model->where('status', StatusType::DEACTIVATED);
        } else {
            $query = $this->model->where('status', '!=', StatusType::DEACTIVATED);
        }
        $query = $query->orderBy($sortField, $filters['order']);

        $searchQuery = $filters['search'];

        if (!empty($searchQuery)) {
            $query = $query->where(
                function ($query) use ($searchQuery) {
                    $query->orWhere('full_name->first_name', 'like', "%{$searchQuery}%")
                        ->orWhere('full_name->last_name', 'like', "%{$searchQuery}%")
                        ->orWhere('email', 'like', "%{$searchQuery}%")
                        ->orWhere('status', 'like', "%{$searchQuery}%")
                        ->orWhere('username', 'like', "%{$searchQuery}%");
                }
            );
        }

        return $query->paginate($filters['per_page']);
    }

    /**
     * Get users by role.
     * @param string $role
     * @return Collection
     */
    public function getUsersByRole(string $role): Collection
    {
        return $this->model->role($role)->pluck('full_name', 'id');
    }

    /**
     * Creates user with role.
     *
     * @param array $inputData
     * @return User
     * @throws \Exception
     */
    public function createUserWithRole(array $inputData): User
    {
        $this->databaseManager->beginTransaction();
        try {
            $user = $this->create($inputData);
            $user->assignRole($inputData['role']);
        } catch (\Exception $exception) {
            $this->databaseManager->rollBack();
            throw $exception;
        }
        $this->databaseManager->commit();

        return $user;
    }

    /**
     * Updates user with role.
     *
     * @param array  $updateData
     * @param string $userId
     * @return User
     * @throws \Exception
     */
    public function updateUserWithRole(array $updateData, string $userId): User
    {
        $this->databaseManager->beginTransaction();
        try {
            $user = $this->update($updateData, $userId);
            if (array_key_exists('role', $updateData)) {
                $user->syncRoles($updateData['role']);
            }
        } catch (\Exception $exception) {
            $this->databaseManager->rollBack();
            throw $exception;
        }
        $this->databaseManager->commit();

        return $user;
    }

    /**
     * Changes password of a user.
     *
     * @param string $userId
     * @param string $password
     * @return User
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function changePassword(string $userId, string $password): User
    {
        return $this->update(['password' => bcrypt($password)], $userId);
    }
}
