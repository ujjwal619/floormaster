<?php

namespace App\Data\Repositories\Stock;

use App\Data\Entities\Models\Stock\CurrentOrder;
use App\StartUp\BaseClasses\Repository\BaseRepository;

class CurrentOrderEloquentRepository extends BaseRepository implements CurrentOrderRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CurrentOrder::class;
    }

    public function getLatest()
    {
        return $this->model->where('is_archived', false)->latest()->first();
    }
}
