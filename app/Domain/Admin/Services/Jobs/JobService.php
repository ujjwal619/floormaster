<?php

namespace App\Domain\Admin\Services\Jobs;

use App\Data\Entities\Models\Job\Job;
use App\Data\Entities\Models\Quote\Quote;
use App\Data\Repositories\Job\JobRepository;
use App\Domain\Admin\Resources\Job\JobResource;
use App\FMS\Client\Manager;

/**
 * Class JobService
 * @package App\Domain\Admin\Services\Jobs
 */
class JobService
{

    /**
     * @var JobRepository
     */
    protected $jobRepository;

    protected $clientManager;

    public function __construct(JobRepository $jobRepository, Manager $clientManager)
    {
        $this->jobRepository = $jobRepository;
        $this->clientManager = $clientManager;
    }

    /**
     * Get the paginated jobs for data table.
     *
     * @param array $filters
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getPaginatedJobsForTable(array $filters)
    {
        $quotes = $this->jobRepository->getPaginatedJobsWith($filters);

        return JobResource::collection($quotes);
    }

    /**
     * @param Quote $quote
     * @return Job
     */
    public function createJobFromQuote(Quote $quote, array $inputData)
    {
        return $this->jobRepository->createJobFromQuote($quote, $inputData);
    }

    /**
     * Find job by its id.
     *
     * @param int $jobId
     *
     * @return Job
     */
    public function findById(int $jobId): Job
    {
        return $this->jobRepository->with([
            'sales',
            'labourSalesPrice',
            'customer',
            'materials.variant',
            'materials.supplier.site',
            'materials.product.supplier',
            'invoices.receipts',
            'site',
            'shop',
            'allocationsAndBackOrders',
            'dispatches',
            'creditorsPayables.supplier',
            'paidPayables',
            'salesCode',
            'contractorsPayables.contractor',
            'memoReferences.user',
            'futureStocks'
        ])->find($jobId);
    }

    /**
     * Find job by its id with customer.
     *
     * @param int $jobId
     *
     * @return Job
     */
    public function getWithSalesPerson(int $jobId): Job
    {
        return $this->jobRepository->getWithSalesPerson($jobId);
    }

    /**
     * Update the job with sales, material and labour costs.
     *
     * @param array $updateData
     * @param int   $jobId
     *
     * @return mixed
     */
    public function update(array $updateData, int $jobId): Job
    {
        return $this->jobRepository->updateJobWithSalesAndPrices($updateData, $jobId);
    }

    /**
     * Delete the job.
     *
     * @param int $jobId
     *
     * @return int
     */
    public function delete(int $jobId)
    {
        return $this->jobRepository->delete($jobId);
    }

    /**
     * Create job
     *
     * @param array $inputData
     *
     * @return mixed
     */
    public function createJob(array $inputData): Job
    {
        // if (array_get($inputData, 'customerDetails.manual', false) === true) {
        //     $data['customer'] = $inputData['customerDetails'];
        //     $customer = $this->clientManager->create($inputData['job']['site_id'], $data['customer']);

        //     $inputData['job']['customer_id'] = $customer->id;
        // }

        return $this->jobRepository->createJobWithSalesPrices($inputData);
    }

    /**
     * Find the latest id of the job.
     * @return Job
     */
    public function findLatest(): Job
    {
        return $this->jobRepository->getLatest();
    }
}
