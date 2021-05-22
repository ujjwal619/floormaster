<?php

namespace App\Data\Repositories\Stock;

use Prettus\Repository\Contracts\RepositoryInterface;

interface CurrentOrderRepository extends RepositoryInterface
{
    public function getLatest();
}
