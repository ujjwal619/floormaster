<?php

namespace App\FMS\Reports;

use App\FMS\Reports\Job\Actions\ExportBilling;
use App\FMS\Reports\Job\Actions\ExportCommission;
use App\FMS\Reports\Job\Actions\ExportJobCosts;
use App\FMS\Reports\Job\Actions\ExportMIT;
use App\FMS\Reports\Job\Actions\ExportTaking;
use App\FMS\Reports\Job\Actions\ExportUnderInvoiced;
use App\FMS\Reports\Job\Actions\ExportWorkInProgress;
use App\FMS\Reports\Job\Actions\ListBilling;
use App\FMS\Reports\Job\Actions\ListCommission;
use App\FMS\Reports\Job\Actions\ListJobCosts;
use App\FMS\Reports\Job\Actions\ListMIT;
use App\FMS\Reports\Job\Actions\ListTakings;
use App\FMS\Reports\Job\Actions\ListUnderInvoiced;
use App\FMS\Reports\Job\Actions\ListWorkInProgress;
use App\FMS\Reports\Product\Actions\ExportColourways;
use App\FMS\Reports\Product\Actions\ExportFullPriceListBySupplier;
use App\FMS\Reports\Product\Actions\ExportShortPriceListSquareUnit;
use App\FMS\Reports\Product\Actions\ListColourways;
use App\FMS\Reports\Product\Actions\ListProduct;
use Illuminate\Routing\Router;

class RouteCollection
{
    /**
     * @var Router
     */
    private $router;

    /**
     * RouteCollection constructor.
     *
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function __invoke()
    {
        $this->router->group(
            [
                'prefix' => 'api/reports',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/job/billing', ListBilling::class);
            $router->get('/job/wip', ListWorkInProgress::class);
            $router->get('/job/taking', ListTakings::class);
            $router->get('/job/commission', ListCommission::class);
            $router->get('/job/job-costs', ListJobCosts::class);
            $router->get('/job/mit', ListMIT::class);
            $router->get('/job/under-invoiced', ListUnderInvoiced::class);
            $router->get('/products', ListProduct::class);
            $router->get('/products/colourways', ListColourways::class);
            
            $router->get('/job/job-costs/export', ExportJobCosts::class);
            $router->get('/job/under-invoiced/export', ExportUnderInvoiced::class);
            $router->get('/job/mit/export', ExportMIT::class);
            $router->get('/job/taking/export', ExportTaking::class);
            $router->get('/job/billing/export', ExportBilling::class);
            $router->get('/job/wip/export', ExportWorkInProgress::class);
            $router->get('/job/commission/export', ExportCommission::class);
            $router->get('/product/full-price-list-by-supplier/export', ExportFullPriceListBySupplier::class);
            $router->get('/product/short-price-list-square-unit/export', ExportShortPriceListSquareUnit::class);
            $router->get('/product/colourways/export', ExportColourways::class);
        });
    }
}
