<?php

namespace App\Data\Repositories\Customer;

use App\Data\Entities\Models\Customer\Customer;
use App\StartUp\BaseClasses\Repository\BaseRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Database\DatabaseManager;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class CustomerEloquentRepository
 * @package App\Data\Repositories\Customer
 */
class CustomerEloquentRepository extends BaseRepository implements CustomerRepository
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
        return Customer::class;
    }

    /**
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getPaginatedCustomersWith(array $filters): LengthAwarePaginator
    {
        $sortField = array_get($this->filterFields, $filters['column']) ?? $filters['column'];


        $query = $this->model->orderBy($sortField, $filters['order']);

        $searchQuery = $filters['search'];

        if (!empty($searchQuery)) {
            $query = $query->where(
                function ($query) use ($searchQuery) {
                    $query->orWhere('trading_name', 'like', "%{$searchQuery}%")
                        ->orWhere('phone', 'like', "%{$searchQuery}%")
                        ->orWhere('fax', 'like', "%{$searchQuery}%");
                }
            );
        }

        return $query->paginate($filters['per_page']);
    }

    /**
     * Create new customer with sites , attach sales and job lists.
     * @param array $inputData
     * @return Customer
     * @throws \Exception
     */
    public function createCustomerWithSitesAndSales(array $inputData): Customer
    {
        $customerData = $inputData['customer'];
        $sites        = array_get($inputData, 'sites', []);
        $sales        = array_get($inputData, 'selectedSales', []);
        $jobs         = array_get($inputData, 'selectedJobs', []);
        $settings     = array_get($inputData, 'settings', []);

        $this->databaseManager->beginTransaction();
        try {
            $customer = $this->create($customerData);
            collect($sites)->each(function ($site) use ($customer) {
                $customer->sites()->create($site);
            });

            collect($sales)->each(function ($sale) use ($customer) {
                $customer->sales()->attach($sale);
            });

            collect($jobs)->each(function ($job) use ($customer) {
                $customer->jobSources()->attach($job);
            });

            $customer->setting()->create(['general' => $settings]);

            $this->databaseManager->commit();
        } catch (\Exception $exception) {
            $this->databaseManager->rollBack();
            throw $exception;
        }

        return $customer;
    }

    /**
     * @param array $updateData
     * @param int   $customerId
     * @return Customer
     * @throws \Exception
     */
    public function updateCustomerWithJobSourcesAndSales(array $updateData, int $customerId): Customer
    {
        $customerData    = $updateData['customer'];
        $deletedSitesIds = array_get($updateData, 'deletedSites', []);
        $sites           = array_get($updateData, 'sites', []);
        $sales           = array_get($updateData, 'selectedSales', []);
        $jobs            = array_get($updateData, 'selectedJobs', []);
        $settings        = array_get($updateData, 'settings', []);

        $this->databaseManager->beginTransaction();
        try {
            $customer = $this->update($customerData, $customerId);

            collect($deletedSitesIds)->each(function ($siteId) use ($customer) {
                $customer->sites()->where('id', $siteId)->delete();
            });

            collect($sites)->each(function ($site) use ($customer) {
                if (array_has($site, 'id')) {
                    $site = array_only($site, ['id', 'shop_name', 'gl_suffix']);

                    return $customer->sites()->where('id', $site['id'])->update($site);
                }
                $customer->sites()->create($site);
            });

            $customer->sales()->sync($sales);

            $customer->jobSources()->sync($jobs);

            $customer->setting()->update(['general' => json_encode($settings)]);

            $this->databaseManager->commit();
        } catch (\Exception $exception) {
            $this->databaseManager->rollBack();
            throw $exception;
        }

        return $customer;
    }

}
