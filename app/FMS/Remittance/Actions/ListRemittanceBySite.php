<?php

namespace App\FMS\Remittance\Actions;

use App\FMS\Remittance\Models\Remittance;
use App\FMS\Site\Models\Site;
use App\StartUp\BaseClasses\Controller\AdminController;

class ListRemittanceBySite extends AdminController
{
    public function __invoke(Site $site, Remittance $remittance)
    {
        $listRemittance = $remittance->newQuery()
            ->with(['supplier', 'contractor'])
            ->where(['site_id' => $site->id, 'is_paid' => true])
            ->get()
            ->toArray();

        return $this->sendSuccessResponse($listRemittance);
    }
}
