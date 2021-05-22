<?php

namespace App\FMS\Account\Actions;

use App\Data\Entities\Models\Account\Account;
use App\FMS\Account\Manager;
use App\FMS\Site\Models\Site;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;

class ListAccountBySite extends AdminController
{
    public function __invoke(Site $site, Request $request, Account $account)
    {
        $familyId = $request->get('family_id');
        $periodType = $request->get('period_type');
        $type = $request->get('type');
        $date = $request->get('date');

        $accounts = $account->newQuery()
            ->leftJoin(
                'account_yearly_monthly_total as accountTotal', 
                function (JoinClause $joinClause) use($periodType, $date, $site) {
                return $joinClause->on('accountTotal.account_id', 'tbl_accounts.id')
                    ->where('accountTotal.type', $periodType)
                    ->where('accountTotal.date', $date)
                    ->where('accountTotal.site_id', $site->id);
            })
            ->select(
                'tbl_accounts.id as id',
                'tbl_accounts.family as family',
                'tbl_accounts.name as name',
                'tbl_accounts.type as type',
                'tbl_accounts.code as code',
                'tbl_accounts.gst_applicable as gst_applicable',
                'tbl_accounts.reports_to as reports_to',
                'tbl_accounts.opening_balance as opening_balance',
                'accountTotal.amount as account_balance',
                'tbl_accounts.total_balance as total_balance',
                'tbl_accounts.site_id as site_id'
            )
            ->where('tbl_accounts.site_id', $site->id);

        if ($familyId) {
            $accounts->where('tbl_accounts.family', $familyId);
        }

        if ($type) {
            $accounts->where('tbl_accounts.type', $type);
        }

        $accounts = $accounts->get();

        return $this->sendSuccessResponse(
            $accounts->toArray()
        );
    }
}
