<?php

namespace App\FMS\Supplier\Actions;

use App\Data\Entities\Models\Product\Product;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class CreateColor extends AdminController
{
    public function __invoke(Product $product, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'reorder' => 'numeric'
        ]);

        if (!$product->productVariants()->create($request->all())) {
            abort('204', 'Could not create Color.');
        }

        return $this->sendSuccessResponse([], 'Color created successfully.');
    }
}
