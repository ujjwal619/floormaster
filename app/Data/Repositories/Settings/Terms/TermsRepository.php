<?php

namespace App\Data\Repositories\Settings\Terms;

use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface QuoteRepository
 * @package App\Data\Repositories\Quote
 */
interface TermsRepository extends RepositoryInterface
{
    /**
     * Returns the paginated terms with different filters.
     *
     * @param array $filters
     *
     * @return LengthAwarePaginator
     */
    public function getPaginatedTermsWith(array $filters): LengthAwarePaginator;

}