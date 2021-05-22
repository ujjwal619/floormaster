<?php

namespace App\Data\Repositories\User\Permission;

use App\Data\Entities\Models\User\Permission;
use App\StartUp\BaseClasses\Repository\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class PermissionEloquentRepository
 * @package App\Data\Repositories\User\Permission
 */
class PermissionEloquentRepository extends BaseRepository implements PermissionRepository
{
    /**
     * @var array
     */
    protected $filterFields = [
        'id'   => 'id',
        'name' => 'title',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Permission::class;
    }

    /**
     * Get the paginated permissions with filters.
     * @param array $filters
     * @return mixed
     */
    public function getPaginatedModulesWith(array $filters): LengthAwarePaginator
    {
        $sortField   = array_get($this->filterFields, $filters['column']) ?? $filters['column'];
        $query       = $this->model->orderBy($sortField, $filters['order']);
        $searchQuery = $filters['search'];

        if (!empty($searchQuery)) {
            $query = $query->where(
                function ($query) use ($searchQuery) {
                    $query->orWhere('name', 'like', "%{$searchQuery}%");
                    $query->orWhere('title', 'like', "%{$searchQuery}%");
                }
            );
        }

        return $query->paginate($filters['per_page']);
    }
}
