<?php

namespace App\Data\Repositories\Product;

use App\Constants\DBTable;
use App\Data\Entities\Models\Booking\Booking;
use App\Data\Entities\Models\Booking\BookingType;
use App\Data\Entities\Models\Product\Product;
use App\Data\Entities\Models\Supplier\Supplier;
use App\StartUp\BaseClasses\Repository\BaseRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class BookingEloquentRepository
 * @package App\Data\Repositories\Booking
 */
class ProductEloquentRepository extends BaseRepository implements ProductRepository
{
    /**
     * @var DatabaseManager
     */
    private $databaseManager;

    /**
     * BookingEloquentRepository constructor.
     * @param Application $application
     * @param DatabaseManager $databaseManager
     */
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
        return Product::class;
    }

    public function save(Supplier $supplier, array $details)
    {
        $product = $supplier->products()->create($details);
        $product->productVariants()->createMany($details['variants']);
        return $product;
    }

    public function edit(int $id, array $details)
    {
        $user = request()->user();
        $sites = $user->getSiteIds();
        if (!$sites->contains(array_get($details, 'site_id'))) {
            throw new \Exception('Unauthorized site.', 401);
        }
        $product = $this->update($details, $id);
        $productVariants = $product->productVariants;
        $variants = $details['variants'];
        $deletedVariantsIds = $productVariants
            ->pluck('id')
            ->diff(
                collect($variants)->pluck('id')
            );
            
        $deletedVariantsIds->each(function ($variantId) use ($productVariants) {
            $variant = $productVariants->firstWhere('id', $variantId);
            $variant->delete();
        });
        foreach ($variants as $variant) {
            $product->productVariants()->updateOrCreate(['id' => $variant['id'] ?? 0], $variant);
        }
        return $product;
    }

    /**
     * Get the latest product.
     * @return Product
     * @throws ModelNotFoundException
     */
    public function getLatest()
    {
        return $this->model->latest()->first();
    }

    public function getAll(int $supplierId = null)
    {
        $products = $this->model->newQuery()
            ->join(DBTable::SUPPLIERS, DBTable::SUPPLIERS.'.id', DBTable::PRODUCTS.'.supplier_id')
            ->select(
                DBTable::PRODUCTS.'.id',
                DBTable::PRODUCTS.'.name',
                DBTable::PRODUCTS.'.alias',
                DBTable::PRODUCTS.'.list_cost',
                DBTable::PRODUCTS.'.trade_sell',
                DBTable::PRODUCTS.'.retail_sell',
                DBTable::PRODUCTS.'.installed',
                DBTable::PRODUCTS.'.upc',
                DBTable::PRODUCTS.'.gst',
                DBTable::SUPPLIERS.'.trading_name as supplier_name'
            );
        if ($supplierId) {
            $products->where(DBTable::PRODUCTS.'.supplier_id', $supplierId);
        }

        return $products->get();
    }

    /**
     * @param string $jobId
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getByJob(string $jobId)
    {
        $bookings = $this->model->newQuery()
            ->join(DBTable::BOOKING_TYPES, DBTable::BOOKING_TYPES.'.id', DBTable::BOOKINGS.'.booking_type_id')
            ->where(DBTable::BOOKINGS.'.job_id', $jobId)
            ->select(
                DBTable::BOOKINGS.'.date as booking_date',
                DBTable::BOOKINGS.'.id as booking_id',
                DBTable::BOOKINGS.'.for as booking_for',
                DBTable::BOOKINGS.'.booking_type_id',
                DBTable::BOOKING_TYPES.'.name as booking_type'
            )
            ->get();

        return $bookings;
    }
}
