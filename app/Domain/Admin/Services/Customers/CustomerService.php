<?php

namespace App\Domain\Admin\Services\Customers;

use App\Data\Entities\Models\Customer\Customer;
use App\Data\Repositories\Customer\CustomerRepository;
use App\Domain\Admin\Resources\Customers\CustomerResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * Class CustomerService
 * @package App\Domain\Admin\Services\Customers
 */
class CustomerService
{
    /**
     * @var CustomerRepository
     */
    protected $customerRepository;

    /**
     * CustomerService constructor.
     * @param CustomerRepository $customerRepository
     */
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * Create new customer.
     * @param array $inputData
     * @return Customer
     * @throws \Exception
     */
    public function createCustomer(array $inputData): Customer
    {
        return $this->customerRepository->createCustomerWithSitesAndSales($inputData);
    }

    /**
     * Get the paginated customers with filters for data table.
     * @param array $filters
     * @return JsonResource
     */
    public function getPaginatedCustomersForTable(array $filters): JsonResource
    {
        $customers = $this->customerRepository->getPaginatedCustomersWith($filters);

        return CustomerResource::collection($customers);
    }

    /**
     * Delete the customer.
     * @param int $customerId
     * @return bool
     */
    public function delete(int $customerId): bool
    {
        return (bool)$this->customerRepository->delete($customerId);
    }

    /**
     * Find customer by id.
     * @param int $customerId
     * @return Customer
     */
    public function findById(int $customerId): Customer
    {
        return $this->customerRepository->find($customerId);
    }

    /**
     * Update the instance of customer.
     * @param array $updateData
     * @param int   $customerId
     * @return Customer
     * @throws \Exception
     */
    public function update(array $updateData, int $customerId): Customer
    {
        return $this->customerRepository->updateCustomerWithJobSourcesAndSales($updateData, $customerId);
    }

    /**
     * Get all customers.
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->customerRepository->all();
    }

    /**
     * Get the latest quote.
     * @param int $customerId
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\HasMany|object|null
     */
    public function getLatestQuote(int $customerId)
    {
        $customer = $this->findById($customerId);

        return $customer->quotes()->latest()->first();
    }
}
