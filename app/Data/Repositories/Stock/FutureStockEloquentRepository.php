<?php

namespace App\Data\Repositories\Stock;

use App\Data\Entities\Models\Product\Product;
use App\Data\Entities\Models\Stock\CurrentStock;
use App\Data\Entities\Models\Stock\FutureStock;
use App\StartUp\BaseClasses\Repository\BaseRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Database\DatabaseManager;

class FutureStockEloquentRepository extends BaseRepository implements FutureStockRepository
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
        return FutureStock::class;
    }
}
