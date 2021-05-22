<?php

namespace App\Domain\Admin\Services\Stock;

use App\Data\Repositories\Stock\CurrentOrderRepository;

class CurrentOrderService
{
    private $repository;

    public function __construct(CurrentOrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findLatest()
    {
        return $this->repository->getLatest();
    }

    public function find(int $id)
    {
        return $this->repository->with([
            'futureStocks.color.product.supplier', 
            'futureStocks.currentStocks',
            'job',
            'site'
        ])->find($id);
    }
}
