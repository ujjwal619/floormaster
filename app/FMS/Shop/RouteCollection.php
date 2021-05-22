<?php

namespace App\FMS\Shop;

use App\FMS\Shop\Actions\CreateShop;
use App\FMS\Shop\Actions\ListShop;
use App\FMS\Shop\Actions\UpdateShop;
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
                'prefix' => 'api/sites/{site}/shops',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->post('/', CreateShop::class);
            $router->get('/', ListShop::class);
        });

        $this->router->group(
            [
                'prefix' => 'api/shops/{shop}',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->put('/', UpdateShop::class);
        });
    }
}
