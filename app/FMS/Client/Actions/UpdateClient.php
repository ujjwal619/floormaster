<?php

namespace App\FMS\Client\Actions;

use App\Data\Entities\Models\Customer\Customer;
use App\FMS\Client\Manager;
use App\FMS\Client\Requests\CreateRequest;
use App\StartUp\BaseClasses\Controller\AdminController;

class UpdateClient extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:client.access.edit.client']);
    }

    public function __invoke(Customer $customer, CreateRequest $request, Manager $manager)
    {
        if (!$manager->update($customer, $request->all())) {
            abort('204', 'Could not update Client.');
        }

        return $this->sendSuccessResponse([], 'Client updated successfully.');
    }
}
