<?php

namespace App\FMS\Client\Actions;

use App\Data\Entities\Models\Customer\Customer;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ShowClient extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:client.access']);
    }

    public function __invoke(Customer $customer, Request $request)
    {
        $customer = $customer->fresh(['term']);
        $customer->address = empty($customer->address) ? null : $customer->address;
        $sites = $request->user()->getSiteIds();
        if (!$sites->contains($customer->site_id)) {
            abort('401', 'Unauthorized site.');
        }

        return $this->sendSuccessResponse($customer->toArray());
    }
}
