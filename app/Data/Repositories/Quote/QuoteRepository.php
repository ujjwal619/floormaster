<?php

namespace App\Data\Repositories\Quote;

use App\Data\Entities\Models\Quote\Quote;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface QuoteRepository
 * @package App\Data\Repositories\Quote
 */
interface QuoteRepository extends RepositoryInterface
{

    /**
     * Add new quote with the pivot sales - labour & material.
     * @param $inputData
     * @return mixed
     */
    public function createQuotesWithSalesPrices($inputData): Quote;

    /**
     * Returns the paginated quotes with different filters.
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getPaginatedQuotesWith(array $filters): LengthAwarePaginator;

    /**
     * Update quote with the pivot sales - labour & material.
     * @param array $updateData
     * @param int   $quoteID
     * @return Quote
     * @throws \Exception
     */
    public function updateQuoteWithSalesPrices(array $updateData, int $quoteID): Quote;

    /**
     * Get the latest quote.
     * @return Quote
     * @throws \Exception
     */
    public function getLatest(): Quote;
}