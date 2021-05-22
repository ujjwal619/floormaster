<?php

namespace App\FMS\Product\Actions;

use App\Data\Entities\Models\Product\Product;
use App\Data\Entities\Models\Supplier\Supplier;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ShowProduct extends AdminController
{
    public function __construct()
    {
        // $this->middleware(['permission:suppliers|suppliers.list']);
    }

    public function __invoke(Product $product, Request $request)
    {
        $sites = $request->user()->getSiteIds();
        // dd($product, $sites);
        if (!$sites->contains($product->site_id)) {
            abort('401', 'Unauthorized site.');
        }

        return $this->sendSuccessResponse($product->toArray());
    }
}
