<?php

namespace App\FMS\Stock;

use App\FMS\Stock\Actions\AllocateCurrentStock;
use App\FMS\Stock\Actions\AllocateFutureStock;
use App\FMS\Stock\Actions\Allocation\DeleteAllocation;
use App\FMS\Stock\Actions\Allocation\DispatchAllocation;
use App\FMS\Stock\Actions\Allocation\ListAllocation;
use App\FMS\Stock\Actions\Allocation\ListAllocationBySite;
use App\FMS\Stock\Actions\Allocation\MoveAllocationToCurrentStock;
use App\FMS\Stock\Actions\Allocation\UnlinkAllocation;
use App\FMS\Stock\Actions\Allocation\UpdateAllocation;
use App\FMS\Stock\Actions\BackOrder\DeleteBackOrder;
use App\FMS\Stock\Actions\Allocation\MoveAllocationToFutureStock;
use App\FMS\Stock\Actions\BackOrder\MoveBackOrderToCurrentStock;
use App\FMS\Stock\Actions\BackOrder\MoveBackOrderToFutureStock;
use App\FMS\Stock\Actions\BackOrder\UnlinkBackOrder;
use App\FMS\Stock\Actions\BackOrder\UpdateBackOrder;
use App\FMS\Stock\Actions\CreateMarryInvoice;
use App\FMS\Stock\Actions\DisableAllocationProcess;
use App\FMS\Stock\Actions\EnableAllocationProcess;
use App\FMS\Stock\Actions\ListCurrentStocksByColor;
use App\FMS\Stock\Actions\ListStocksByColor;
use App\FMS\Stock\Actions\OrderStockFromJob;
use App\FMS\Stock\Actions\ShowFutureStock;
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
                'prefix' => 'api/color/{productVariant}',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/stocks', ListStocksByColor::class);
            $router->get('/current-stocks', ListCurrentStocksByColor::class);
            $router->patch('/enable-allocation-process', EnableAllocationProcess::class);
            $router->patch('/disable-allocation-process', DisableAllocationProcess::class);
            $router->post('/order-stock-from-job/{jobMaterialSale}', OrderStockFromJob::class);
        });

        $this->router->group(
            [
                'prefix' => 'api/sites/{site}',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/allocations', ListAllocationBySite::class);
        });

        $this->router->group(
            [
                'prefix' => 'api/allocations',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/', ListAllocation::class);
            $router->put('/{allocation}', UpdateAllocation::class);
            $router->put('/{allocation}/unlink', UnlinkAllocation::class);
            $router->delete('/{allocation}', DeleteAllocation::class);
            $router->patch('/{allocation}/dispatch', DispatchAllocation::class);
            $router->patch('/{allocation}/move/current-stocks/{currentStock}', MoveAllocationToCurrentStock::class);
            $router->patch('/{allocation}/move/future-stocks/{futureStock}', MoveAllocationToFutureStock::class);
        });

        $this->router->group(
            [
                'prefix' => 'api/back-orders',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->put('/{backOrder}', UpdateBackOrder::class);
            $router->delete('/{backOrder}', DeleteBackOrder::class);
            $router->patch('/{backOrder}/unlink', UnlinkBackOrder::class);
            $router->patch('/{backOrder}/move/current-stocks/{currentStock}', MoveBackOrderToCurrentStock::class);
            $router->patch('/{backOrder}/move/future-stocks/{futureStock}', MoveBackOrderToFutureStock::class);
        });

        $this->router->group(
            [
                'prefix' => 'api/current-stocks',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->post('/{currentStock}/allocate', AllocateCurrentStock::class);
        });

        $this->router->group(
            [
                'prefix' => 'api/future-stocks',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->post('/{futureStock}/allocate', AllocateFutureStock::class);
            $router->post('/{futureStock}/marry-invoices', CreateMarryInvoice::class);
            $router->get('/{futureStock}', ShowFutureStock::class);
        });
    }
}
