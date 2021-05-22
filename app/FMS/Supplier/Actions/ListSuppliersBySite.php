<?php

namespace App\FMS\Supplier\Actions;

use App\Data\Entities\Models\Supplier\Supplier;
use App\FMS\Site\Models\Site;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ListSuppliersBySite extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:suppliers|suppliers.list']);
    }

    public function __invoke(Site $site, Supplier $supplier, Request $request)
    {
        $for = $request->get('for');
        $suppliers = $supplier->newQuery();

        if ($for === "priceList") {
            if ($site->id === 3 || $site->id === 4) {
                $suppliers->where(
                    function ($query) {
                        $query->orWhere('site_id', 3)
                            ->orWhere('site_id', 4);
                    }
                );
            }
        } else {
            $suppliers->where('site_id', $site->id);
        }

        $suppliers = $suppliers->get()
            ->toArray();

        return $this->sendSuccessResponse($suppliers);
    }
}
