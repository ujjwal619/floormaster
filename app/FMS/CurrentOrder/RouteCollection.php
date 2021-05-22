<?php

namespace App\FMS\CurrentOrder;

use App\FMS\CurrentOrder\Actions\ArchiveCurrentOrder;
use App\FMS\CurrentOrder\Actions\CreateMarryInvoice;
use App\FMS\CurrentOrder\Actions\ListCurrentOrder;
use App\FMS\CurrentOrder\Actions\ShowCurrentOrder;
use App\FMS\CurrentOrder\Actions\UpdateCurrentOrder;
use App\FMS\CurrentOrder\Actions\CreateCurrentOrder;
use App\FMS\CurrentOrder\Actions\IndexCurrentOrder;
use App\FMS\CurrentOrder\Actions\ReceiveGeneralOrder;
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
                'prefix' => '/api/current-orders',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
                $router->post('/', CreateCurrentOrder::class);
                $router->post('/{currentOrder}/archive', ArchiveCurrentOrder::class);
                $router->put('/{currentOrder}', UpdateCurrentOrder::class);
                $router->put('/{currentOrder}/future-stocks/{futureStock}/receive-general-order', ReceiveGeneralOrder::class);
                $router->get('/index', IndexCurrentOrder::class);
                $router->get('/{currentOrder}', ShowCurrentOrder::class);
                $router->get('/', ListCurrentOrder::class);
        });
    }
}
