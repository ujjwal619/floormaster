<?php

namespace App\Data\Repositories\Supplier;

use App\Data\Entities\Models\Supplier\Supplier;
use App\StartUp\BaseClasses\Repository\BaseRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class SupplierEloquentRepository
 * @package App\Data\Repositories\Customer
 */
class SupplierEloquentRepository extends BaseRepository implements SupplierRepository
{
    /**
     * @var DatabaseManager
     */
    protected $databaseManager;

    /**
     * SupplierEloquentRepository constructor.
     * @param Application     $app
     * @param DatabaseManager $databaseManager
     */
    public function __construct(Application $app, DatabaseManager $databaseManager)
    {
        parent::__construct($app);
        $this->databaseManager = $databaseManager;
    }

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
        return Supplier::class;
    }

    /**
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getPaginatedSuppliersWith(array $filters): LengthAwarePaginator
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
     * Creates a supplier with other data.
     *
     * @param $inputData
     * @return Supplier
     * @throws \Exception
     */
    public function createSupplierWithSalesAndSites(array $inputData): Supplier
    {
        $this->databaseManager->beginTransaction();
        try {
            $supplier = $this->create($inputData['supplier']);
            collect($inputData['sites'])->each(function ($site) use ($supplier) {
                $supplier->sites()->create($site);
            });
            collect($inputData['selectedJobs'])->each(function ($jobId) use ($supplier) {
                $supplier->jobSources()->attach($jobId);
            });
            collect($inputData['selectedSales'])->each(function ($salesId) use ($supplier) {
                $supplier->salesStaffs()->attach($salesId);
            });
        } catch (\Exception $exception) {
            $this->databaseManager->rollBack();
            throw $exception;
        }

        $this->databaseManager->commit();

        return $supplier;
    }

    /**
     * Updates a supplier with other data.
     *
     * @param $updateData
     * @param $supplierId
     * @return Supplier
     * @throws \Exception
     */
    public function updateSupplierWithSalesAndSites(array $updateData, int $supplierId)
    {
        $this->databaseManager->beginTransaction();
        try {
            $supplier = $this->update($updateData['supplier'], $supplierId);
            collect($updateData['selectedJobs'])->each(function ($jobId) use ($supplier) {
                $supplier->jobSources()->sync($jobId);
            });
            collect($updateData['selectedSales'])->each(function ($salesId) use ($supplier) {
                $supplier->salesStaffs()->sync($salesId);
            });
            collect($updateData['deletedSites'])->each(function ($siteId) use ($supplier) {
                $supplier->sites()->where('id', $siteId)->delete();
            });
            collect($updateData['sites'])->each(function ($site) use ($supplier) {
                if (array_has($site, 'id')) {
                    $site = array_only($site, ['id', 'shop_name', 'gl_suffix']);

                    return $supplier->sites()->where('id', $site['id'])->update($site);
                }

                return $supplier->sites()->create($site);
            });
        } catch (\Exception $exception) {
            $this->databaseManager->rollBack();
            throw $exception;
        }

        $this->databaseManager->commit();

        return $supplier;
    }


    /**
     * Get the latest supplier.
     * @return Supplier
     * @throws ModelNotFoundException
     */
    public function getLatest(): Supplier
    {
        $supplier = $this->model->latest()->first();
        if (!$supplier) {
            throw new ModelNotFoundException();
        }

        return $supplier;
    }
}
