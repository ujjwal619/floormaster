<?php

namespace App\FMS\Site\Queries;

use App\FMS\User\Models\User;

class ListUserSites
{
    public function __construct()
    {

    }

    public function fetch(User $user, $for = '')
    {
        if ($for === "share-site") {
            $sites = $user->sharedSites();
        } else {
            $sites = $user->sites();
        }
        return $sites->with([
            'gstBilledOnSales',
            'gstOnCreditors',
            'tradeCreditors',
            'tradeDebtors',
            'moneyInTrust',
            'jobRetention',
            'chequeAccount',
            'deliveryBailing',
            'discountsReceived',
            'retainedEarnings',
            'currentEarnings',
            'retentionReleaseUser',
            'customerComplaintUnresolvedUser',
            'stockBelowReorderUser',
            'purchaseOrdersOverdueUser',
            'jobsInvoicedLessThanQuotedAtComplitionUser',
            'salesStaffs',
            'shops'
        ])
        ->orderBy('created_at')
        ->get()->unique('id')->values()->toArray();
    }
}
