<?php

namespace App\FMS\Supplier\Actions;

use App\Data\Entities\Models\Account\Account;
use App\FMS\Account\ValueObjects\AccountFamilies;
use App\FMS\Account\ValueObjects\AccountTypes;
use App\FMS\Site\Models\Site;
use App\StartUp\BaseClasses\Controller\AdminController;

class AccountDropdownForSupplier extends AdminController
{
    public function __invoke(Site $site, Account $account)
    {
        $accounts = $account->newQuery()
            ->whereIn('family', [AccountFamilies::ASSETS, AccountFamilies::COST_OF_SALES, AccountFamilies::EXPENSES])
            ->where('type', AccountTypes::DETAIL)
            ->where('site_id', $site->id)
            ->get()
            ->toArray();

        return $this->sendSuccessResponse($accounts);
    }
}
