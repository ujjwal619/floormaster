<?php

namespace App\Data\Repositories\User\Role;

use App\Data\Entities\Models\User\Role;
use App\StartUp\BaseClasses\Repository\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class RoleEloquentRepository
 * @package App\Data\Repositories\User\Role
 */
class RoleEloquentRepository extends BaseRepository implements RoleRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Role::class;
    }

    /**
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getPaginatedRolesWith(array $filters): LengthAwarePaginator
    {
        $query       = $this->model->orderBy($filters['column'], $filters['order']);
        $searchQuery = $filters['search'];

        if (!empty($searchQuery)) {
            $query = $query->where(
                function ($query) use ($searchQuery) {
                    $query->orWhere('name', 'like', "%{$searchQuery}%")
                        ->orWhere('title', 'like', "%{$searchQuery}%");
                }
            );
        }

        return $query->paginate($filters['per_page']);
    }
}
