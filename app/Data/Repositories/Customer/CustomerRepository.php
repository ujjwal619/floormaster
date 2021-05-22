<?php

namespace App\Data\Repositories\Customer;

use App\Data\Entities\Models\Customer\Customer;
use App\Data\Entities\Models\Quote\Quote;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CustomerRepository
 * @package App\Data\Repositories\Customer
 */
interface CustomerRepository extends RepositoryInterface
{
    /**
     * Get the paginated customers with filter parameters.
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getPaginatedCustomersWith(array $filters): LengthAwarePaginator;

    /**
     * Create new customer with sites , attach sales and job lists.
     * @param array $inputData
     * @return Customer
     * @throws \Exception
     */
    public function createCustomerWithSitesAndSales(array $inputData): Customer;

    /**
     * @param array $updateData
     * @param int   $customerId
     * @return Customer
     * @throws \Exception
     */
    public function updateCustomerWithJobSourcesAndSales(array $updateData, int $customerId): Customer;
}