<?php

namespace App\FMS\Stock\Events;

use App\Data\Entities\Models\Product\ProductVariant;

class CalculateStockTotal
{
    public $color;

    public function __construct(ProductVariant $color)
    {
        $this->color = $color->load('stock');
    }

    public function color()
    {
        return $this->color;
    }
}
