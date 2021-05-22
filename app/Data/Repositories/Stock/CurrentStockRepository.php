<?php

namespace App\Data\Repositories\Stock;

use App\Data\Entities\Models\Product\Product;
use Prettus\Repository\Contracts\RepositoryInterface;

interface CurrentStockRepository extends RepositoryInterface
{
    public function saveMany(Product $product, array $details);
}
