<?php

namespace App\Data\Repositories\Job;

use App\Data\Entities\Models\Job\Job;
use App\Data\Entities\Models\Quote\Quote;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface QuoteRepository
 * @package App\Data\Repositories\Quote
 */
interface JobRepository extends RepositoryInterface
{

    /**
     * Returns the paginated quotes with different filters.
     *
     * @param array $filters
     *
     * @return LengthAwarePaginator
     */
    public function getPaginatedJobsWith(array $filters): LengthAwarePaginator;

    /**
     * Create new job from the quote details provided.
     *
     * @param Quote $quote
     * @return Job
     */
    public function createJobFromQuote(Quote $quote, array $inputData);

    /**
     * Update the job with the sales and material and labour prices.
     * @param array $updateData
     * @param int   $jobId
     *
     * @return mixed
     */
    public function updateJobWithSalesAndPrices(array $updateData, int $jobId);

    /**
     * Create new job with sales prices.
     * @param array $inputData
     *
     * @return mixed
     */
    public function createJobWithSalesPrices(array $inputData): Job;

    /**
     * Get the latest job.
     * @return Job
     */
    public function getLatest(): Job;

    /**
     * Get job with main sales person
     *
     * @param int $jobId
     * @return Job
     */
    public function getWithSalesPerson(int $jobId): Job;
}
