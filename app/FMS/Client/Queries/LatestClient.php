<?php

namespace App\FMS\Client\Queries;

use App\FMS\Site\Traits\FilterSiteByUserTrait;
use App\FMS\User\Models\User;

class LatestClient
{
    use FilterSiteByUserTrait;

    public function fetch(User $user)
    {
        return $this->filterSiteByUser($user)
            ->join('tbl_customers', 'tbl_customers.site_id', 'sites.id')
            ->select(
                'tbl_customers.id as id',
                'tbl_customers.site_id as site_id',
                'tbl_customers.title as title',
                'tbl_customers.firstname as firstname',
                'tbl_customers.trading_name as trading_name',
                'tbl_customers.address as address',
                'tbl_customers.phone as phone',
                'tbl_customers.work_phone as work_phone',
                'tbl_customers.mobile as mobile',
                'tbl_customers.fax as fax',
                'tbl_customers.email as email',
                'tbl_customers.terms as terms',
                'tbl_customers.attention as attention',
                'tbl_customers.key_no as key_no',
                'tbl_customers.notes as notes'
            )
            ->orderBy('tbl_customers.updated_at', 'DESC')
            ->first();
    }
}
