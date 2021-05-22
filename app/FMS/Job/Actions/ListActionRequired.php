<?php

namespace App\FMS\Job\Actions;

use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Database\Query\Expression;
use Illuminate\Http\Request;

class ListActionRequired extends AdminController
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $site = $request->get('site');
        $job = $request->get('job');
        $jobMaterial = $request->get('job-material');
        $color = $request->get('color');
        $actOn = $request->get('act_on', false);

        $actionRequiredData = $user->newQuery()
        ->join('user_sites', 'user_sites.user_id', 'auth_users.id')
        ->join('sites', 'sites.id', 'user_sites.site_id')
        ->join('tbl_jobs', 'tbl_jobs.site_id', 'sites.id')
        ->join('pivot_jobs_material_sales_price', 'pivot_jobs_material_sales_price.job_id', 'tbl_jobs.id')
        ->join('tbl_products', 'tbl_products.id', 'pivot_jobs_material_sales_price.product_id')
        ->join('tbl_suppliers', 'tbl_suppliers.id', 'tbl_products.supplier_id')
        ->join('tbl_product_variants', 'tbl_product_variants.id', 'pivot_jobs_material_sales_price.variant_id')
        ->where('user_sites.user_id', $user->id)
        ->where('tbl_products.non_product', false)
        ->whereRaw('pivot_jobs_material_sales_price.quantity - COALESCE(pivot_jobs_material_sales_price.allocated, 0) - pivot_jobs_material_sales_price.dispatched > 0')
        ->select(
            'pivot_jobs_material_sales_price.id as id',
            'tbl_jobs.job_id as job_no',
            'tbl_jobs.id as job_id',
            'tbl_jobs.trading_name as client_name',
            'tbl_suppliers.trading_name as supplier_name',
            'tbl_suppliers.id as supplier_id',
            'tbl_products.name as product_name',
            'tbl_products.id as product_id',
            'tbl_products.list_cost as product_list_price',
            'tbl_products.act_on_me as product_act_on_me',
            'tbl_product_variants.name as variant_name',
            'tbl_product_variants.id as variant_id',
            'pivot_jobs_material_sales_price.unit as unit',
            'pivot_jobs_material_sales_price.quantity as quantity',
            'pivot_jobs_material_sales_price.discount as discount',
            'pivot_jobs_material_sales_price.gst as gst',
            'pivot_jobs_material_sales_price.levy as levy',
            'pivot_jobs_material_sales_price.total as total',
            'pivot_jobs_material_sales_price.act_on as act_on',
            'pivot_jobs_material_sales_price.dispatched as dispatched',
            'pivot_jobs_material_sales_price.on_order as on_order',
            'pivot_jobs_material_sales_price.allocated as allocated',
            'pivot_jobs_material_sales_price.material_from as material_from',
            new Expression('
                quantity - COALESCE(pivot_jobs_material_sales_price.allocated, 0) - dispatched as actt_on
            ')
        )
        ;

        if ($site) {
            $actionRequiredData = $actionRequiredData->where('tbl_jobs.site_id', $site);
        }

        if ($job) {
            $actionRequiredData = $actionRequiredData->where('tbl_jobs.id', $job);
        }

        if ($jobMaterial) {
            $actionRequiredData = $actionRequiredData->where('pivot_jobs_material_sales_price.id', $jobMaterial);
        }

        if ($color) {
            $actionRequiredData = $actionRequiredData->where('tbl_product_variants.id', $color);
        }

        if ((bool)$actOn) {
            $actionRequiredData = $actionRequiredData->where('tbl_products.act_on_me', true);
        }

        return $this->sendSuccessResponse(
            $actionRequiredData
                ->get()
                ->toArray()
        );
    }
}
