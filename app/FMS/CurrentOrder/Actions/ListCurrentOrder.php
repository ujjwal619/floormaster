<?php

namespace App\FMS\CurrentOrder\Actions;

use App\FMS\Site\Traits\FilterSiteByUserTrait;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;
use Illuminate\Database\Query\Expression;

class ListCurrentOrder extends AdminController
{
    use FilterSiteByUserTrait;

    public function __invoke(Request $request)
    {
        $user = $request->user();
        $site = $request->get('site_id');
        $color = $request->get('color_id');
        $product = $request->get('product_id');
        $supplier = $request->get('supplier_id');

        $data = $this->filterSiteByUser($user)
            ->join('tbl_current_orders', 'tbl_current_orders.site_id', 'sites.id')
            ->leftJoin('tbl_jobs', 'tbl_jobs.id', 'tbl_current_orders.job_id')
            ->join('tbl_future_stocks', 'tbl_future_stocks.order_number', 'tbl_current_orders.id')
            ->join('tbl_product_variants', 'tbl_product_variants.id', 'tbl_future_stocks.variant_id')
            ->join('tbl_products', 'tbl_products.id', 'tbl_product_variants.product_id')
            ->join('tbl_suppliers', 'tbl_suppliers.id', 'tbl_products.supplier_id')
            ->select(
                'tbl_current_orders.id as id',
                'tbl_product_variants.id as color_id',
                'tbl_product_variants.name as color_name',
                'tbl_products.id as product_id',
                'tbl_products.name as product_name',
                'tbl_suppliers.id as supplier_id',
                'tbl_suppliers.trading_name as supplier_name',
                new Expression('SUM(tbl_future_stocks.quantity) - SUM(tbl_future_stocks.received) AS future_stock_pending'),
                'tbl_future_stocks.unit as future_stock_unit',
                'tbl_current_orders.created_at as created_at',
                'tbl_jobs.trading_name as job_client_name',
                'tbl_jobs.job_id as job_no'

            )
            ->where('tbl_current_orders.is_archived', false);

        if ($site) {
            $data = $data->where('tbl_current_orders.site_id', $site);
        }

        if ($color) {
            $data = $data->where('tbl_product_variants.id', $color);
        }

        if ($product) {
            $data = $data->where('tbl_products.id', $product);
        }

        if ($supplier) {
            $data = $data->where('tbl_suppliers.id', $supplier);
        }

        $data = $data
            ->latest()
            ->groupBy('tbl_future_stocks.id')
            ->get();

        return $this->sendSuccessResponse($data->toArray());
    }
}
