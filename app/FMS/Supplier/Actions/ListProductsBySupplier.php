<?php

namespace App\FMS\Supplier\Actions;

use App\Data\Entities\Models\Supplier\Supplier;
use App\StartUp\BaseClasses\Controller\AdminController;

class ListProductsBySupplier extends AdminController
{
    public function __invoke(Supplier $supplier)
    {
        $supplier->load('products.productVariants');
        $products = $supplier->products()->with(['productVariants', 'supplier'])->get()->toArray();

        return $this->sendSuccessResponse($products);
    }
}
