<?php

namespace App\FMS\Client\Actions;

use App\Data\Entities\Models\Customer\Customer;
use App\FMS\Site\Models\Site;
use App\StartUp\BaseClasses\Controller\AdminController;

class ListClientBySite extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:client.access']);
    }
    
    public function __invoke(Site $site, Customer $client)
    {
        $listClient = $client->newQuery()
            ->where('site_id', $site->id)
            ->get()
            ->toArray();

        return $this->sendSuccessResponse($listClient);
    }
}
