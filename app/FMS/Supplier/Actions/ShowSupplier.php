<?php

namespace App\FMS\Supplier\Actions;

use App\Data\Entities\Models\Supplier\Supplier;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ShowSupplier extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:suppliers|suppliers.list']);
    }

    public function __invoke(Supplier $supplier, Request $request)
    {
        $sites = $request->user()->getSiteIds();
        if (!$sites->contains($supplier->site_id)) {
            abort('401', 'Unauthorized site.');
        }

        return $this->sendSuccessResponse($supplier->fresh([
            'site', 
            'default_cost_account', 
            'levy_account', 
            'payables.job', 
            'central_billing', 
            'remittanceItems.remittance'
        ])->toArray());
    }
}
