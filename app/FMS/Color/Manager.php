<?php

namespace App\FMS\Color;

use App\Data\Entities\Models\Product\ProductVariant;

class Manager
{
    private $color;

    public function __construct(ProductVariant $color)
    {
        $this->color = $color;
    }

    public function findProductVariant(int $id)
    {
        return $this->color->newQuery()->with([
            'stock',
            'currentStocks',
            'futureStocks',
            'product.supplier.site',
            'allocations',
            'backOrders',
            'allocationDispatches'
        ])->find($id);
    }
}
