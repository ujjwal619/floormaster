<?php

namespace App\Data\Repositories\Stock;

use App\Data\Entities\Models\Product\Product;
use App\Data\Entities\Models\Stock\CurrentStock;
use App\StartUp\BaseClasses\Repository\BaseRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Database\DatabaseManager;

class CurrentStockEloquentRepository extends BaseRepository implements CurrentStockRepository
{
    private $databaseManager;

    public function __construct(Application $app, DatabaseManager $databaseManager)
    {
        parent::__construct($app);
        $this->databaseManager = $databaseManager;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CurrentStock::class;
    }

    public function saveMany(Product $product, array $details)
    {
        $totalSize = collect($details)->reduce(function ($carry, $currentStock) {
            return $currentStock['size'] + $carry;
        });

        $this->databaseManager->transaction(function() {

        });
    }
}
