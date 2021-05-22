<?php

namespace App\FMS\Stock\Actions\Allocation;

use App\FMS\Site\Models\Site;
use App\FMS\Stock\Models\Allocation;
use App\StartUp\BaseClasses\Controller\AdminController;

class ListAllocationBySite extends AdminController
{
    public function __invoke(Site $site, Allocation $allocation)
    {
        $allocations = $allocation->newQuery()
            ->join('tbl_product_variants', 'tbl_product_variants.id', 'allocations.variant_id')
            ->join('tbl_products', 'tbl_products.id', 'tbl_product_variants.product_id')
            ->join('tbl_suppliers', 'tbl_suppliers.id', 'tbl_products.supplier_id')
            ->join('tbl_jobs', 'tbl_jobs.id', 'allocations.job_id')
            ->leftJoin('auth_users', 'auth_users.id', 'allocations.created_by_id')
            ->join('tbl_current_stocks', 'tbl_current_stocks.id', 'allocations.current_stock_id')
            ->where('tbl_suppliers.site_id', $site->id)
            ->where('allocations.amount', '>', 0)
            ->select(
                'allocations.id as id',
                'allocations.variant_id as variant_id',
                'allocations.client as client',
                'tbl_jobs.job_id as job_no',
                'tbl_jobs.id as job_id',
                'tbl_jobs.project as project',
                'allocations.current_stock_id as current_stock_id',
                'allocations.date_required as date_required',
                'allocations.amount as amount',
                'allocations.notes as notes',
                'allocations.drop_off as drop_off',
                'allocations.created_at as created_at',
                'auth_users.full_name as created_by',
                'tbl_suppliers.trading_name as supplier_name',
                'tbl_products.name as product_name',
                'tbl_product_variants.name as color_name',
                'tbl_current_stocks.roll_no as current_stock_roll'
            )
            ->get()
            ->toArray();

        return $this->sendSuccessResponse($allocations);
    }
}
