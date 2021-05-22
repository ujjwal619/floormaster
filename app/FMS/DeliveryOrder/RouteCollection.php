<?php

namespace App\FMS\DeliveryOrder;

use App\FMS\DeliveryOrder\Actions\IndexDeliveryOrder;
use App\FMS\DeliveryOrder\Actions\ListDeliveryOrder;
use App\FMS\DeliveryOrder\Actions\ShowDeliveryOrder;
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
                'prefix' => '/api/delivery-orders',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
                $router->get('/index', IndexDeliveryOrder::class);
                $router->get('/', ListDeliveryOrder::class);
                $router->get('/{currentOrder}', ShowDeliveryOrder::class);
        });
    }
}
