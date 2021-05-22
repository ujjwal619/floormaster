<?php

namespace App\Data\Repositories\Stock;

use App\Data\Entities\Models\Stock\Stock;
use App\StartUp\BaseClasses\Repository\BaseRepository;

class StockEloquentRepository extends BaseRepository implements StockRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Stock::class;
    }
}
