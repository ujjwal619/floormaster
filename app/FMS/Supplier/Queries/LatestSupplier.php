<?php

namespace App\FMS\Supplier\Queries;

use App\FMS\Site\Traits\FilterSiteByUserTrait;
use App\FMS\User\Models\User;

class LatestSupplier
{
    use FilterSiteByUserTrait;

    public function fetch(User $user)
    {
        return $this->filterSiteByUser($user)
            ->join('tbl_suppliers', 'tbl_suppliers.site_id', 'sites.id')
            ->leftJoin('tbl_accounts as dca', 'dca.id', 'tbl_suppliers.default_cost_account')
            ->leftJoin('tbl_accounts as la', 'la.id', 'tbl_suppliers.levy_account')
            ->leftJoin('tbl_suppliers as central_billing', 'central_billing.id', 'tbl_suppliers.central_billing')
            ->select(
                'tbl_suppliers.id as id',
                'tbl_suppliers.site_id as site_id',
                'tbl_suppliers.trading_name as trading_name',
                'tbl_suppliers.street as street',
                'tbl_suppliers.phone as phone',
                'tbl_suppliers.fax as fax',
                'tbl_suppliers.abn as abn',
                'tbl_suppliers.code as code',
                'tbl_suppliers.contact as contact',
                'tbl_suppliers.suburb as suburb',
                'tbl_suppliers.email as email',
                'tbl_suppliers.state as state',
                'tbl_suppliers.sales_detail as sales_detail',
                'tbl_suppliers.product_list_url as product_list_url',
                'tbl_suppliers.key_no as key_no',
                'tbl_suppliers.early_discount as early_discount',
                'tbl_suppliers.normal_discount as normal_discount',
                'tbl_suppliers.bank as bank',
                'tbl_suppliers.default_cost_account as default_cost_account',
                'tbl_suppliers.levy_account as levy_account',
                'tbl_suppliers.delivery as delivery',
                'tbl_suppliers.central_billing as central_billing',
                'tbl_suppliers.levy_percent as levy_percent',
                'tbl_suppliers.products as products',
                'dca.id as dca_id',
                'dca.name as dca_name',
                'dca.code as dca_code',
                'la.id as la_id',
                'la.name as la_name',
                'la.code as la_code',
                'central_billing.id as central_billing_id',
                'central_billing.trading_name as central_billing_name',
                'sites.name as site_name'
            )
            ->orderBy('tbl_suppliers.updated_at', 'DESC')
            ->first();
    }
}
