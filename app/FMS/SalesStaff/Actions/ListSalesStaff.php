<?php

namespace App\FMS\SalesStaff\Actions;

use App\FMS\SalesStaff\Models\SalesStaff;
use App\FMS\Site\Models\Site;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ListSalesStaff extends AdminController
{
    public function __invoke(Site $site, Request $request, SalesStaff $salesStaff)
    {
        $listSalesStaff = $salesStaff->newQuery()
            ->where('site_id', $site->id)
            ->get()
            ->toArray();

        return $this->sendSuccessResponse($listSalesStaff);
    }
}
