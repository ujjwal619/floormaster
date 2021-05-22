<?php

namespace App\Data\Repositories\Customer;

use App\Data\Entities\Models\Product\Category;
use App\Data\Repositories\Product\Category\CategoryRepository;
use App\StartUp\BaseClasses\Repository\BaseRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Database\DatabaseManager;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class CustomerEloquentRepository
 * @package App\Data\Repositories\Customer
 */
class CategoryEloquentRepository extends BaseRepository implements CategoryRepository
{
    /**
     * @var array
     */
    protected $filterFields = [];

    /**
     * @var DatabaseManager
     */
    private $databaseManager;

    public function __construct(Application $application, DatabaseManager $databaseManager)
    {
        parent::__construct($application);
        $this->databaseManager = $databaseManager;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Category::class;
    }

    /**
     * Get the paginated customers with filter parameters.
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getPaginatedCategoriesWith(array $filters): LengthAwarePaginator
    {
        $sortField = array_get($this->filterFields, $filters['column']) ?? $filters['column'];

        $query = $this->model->orderBy($sortField, $filters['order']);

        $searchQuery = $filters['search'];

        if (!empty($searchQuery)) {
            $query = $query->where(
                function ($query) use ($searchQuery) {
                    $query->orWhere('name', 'like', "%{$searchQuery}%")
                        ->orWhere('title', 'like', "%{$searchQuery}%")
                        ->orWhere('description', 'like', "%{$searchQuery}%");
                }
            );
        }

        return $query->paginate($filters['per_page']);

    }

    /**
     * Checks if the provided name is unique or not.
     * @param string $name
     * @return bool
     */
    public function nameExists(string $name): bool
    {
        return $this->model->where(['name' => $name])->exists();
    }
}
