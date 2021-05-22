<?php

namespace App\FMS\Supplier\Actions;

use App\Data\Entities\Models\Product\Product;
use App\StartUp\BaseClasses\Controller\AdminController;

class ListColorsByProduct extends AdminController
{
    public function __invoke(Product $product)
    {
        $product->load('productVariants');
        $colors = $product->productVariants()->get()->toArray();

        return $this->sendSuccessResponse($colors);
    }
}
