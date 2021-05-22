<?php

namespace App\Data\Repositories\Settings\Terms;

use App\Data\Entities\Models\Terms\TermsAndCondition;
use App\StartUp\BaseClasses\Repository\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class TermsEloquentRepository
 * @package App\Data\Repositories\Settings\Terms
 */
class TermsEloquentRepository extends BaseRepository implements TermsRepository
{
    /**
     * @var array
     */
    protected $filterFields = [];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TermsAndCondition::class;
    }

    /**
     * Returns the paginated terms with different filters.
     *
     * @param array $filters
     *
     * @return LengthAwarePaginator
     */
    public function getPaginatedTermsWith(array $filters): LengthAwarePaginator
    {
        $sortField = array_get($this->filterFields, $filters['column'], $filters['column']);

        $query = $this->model->orderBy($sortField, $filters['order']);

        $searchQuery = $filters['search'];


        return $query->paginate($filters['per_page']);
    }
}
