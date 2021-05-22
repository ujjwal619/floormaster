<?php

namespace App\Data\Repositories\Product;

use App\Data\Entities\Models\Product\ProductVariant;
use App\StartUp\BaseClasses\Repository\BaseRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Database\DatabaseManager;

/**
 * Class BookingEloquentRepository
 * @package App\Data\Repositories\Booking
 */
class ProductVariantEloquentRepository extends BaseRepository implements ProductVariantRepository
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
        return ProductVariant::class;
    }

    public function getLatest()
    {
        return $this->model->latest()->first();
    }
}
