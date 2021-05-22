<?php

namespace App\FMS\Stock\Actions;

use App\Data\Entities\Models\Product\ProductVariant;
use App\StartUp\BaseClasses\Controller\AdminController;

class ListCurrentStocksByColor extends AdminController
{
    public function __invoke(ProductVariant $productVariant)
    {
        return $this->sendSuccessResponse($productVariant->currentStocks->groupBy('batch')->toArray());
    }
}
