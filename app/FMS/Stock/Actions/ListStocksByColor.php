<?php

namespace App\FMS\Stock\Actions;

use App\Data\Entities\Models\Product\ProductVariant;
use App\StartUp\BaseClasses\Controller\AdminController;

class ListStocksByColor extends AdminController
{
    public function __invoke(ProductVariant $productVariant)
    {
        $stockData = [
            'stock' => $productVariant->stock,
            'currentStock' => $productVariant->currentStocks,
            'futureStock' => $productVariant->futureStocks,
        ];
        return $this->sendSuccessResponse($stockData);
    }
}
