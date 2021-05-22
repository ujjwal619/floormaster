<?php

namespace App\Data\Repositories\JobSource;

use App\Data\Entities\Models\JobSource\JobSource;
use App\StartUp\BaseClasses\Repository\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class JobSourceEloquentRepository
 * @package App\Data\Repositories\JobSource
 */
class JobSourceEloquentRepository extends BaseRepository implements JobSourceRepository
{
    /**
     * @var array
     */
    protected $filterFields = [
        'id'    => 'id',
        'name'  => 'name',
        'title' => 'title',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return JobSource::class;
    }

    /**
     * Get the paginated JobSource with filters.
     * @param $filters
     * @return mixed
     */
    public function getPaginatedJobSourcesWith(array $filters): LengthAwarePaginator
    {
        $sortField = array_get($this->filterFields, $filters['column'], $filters['column']);

        $query = $this->model->orderBy($sortField, $filters['order']);

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
