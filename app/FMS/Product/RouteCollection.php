<?php

namespace App\FMS\Product;

use App\FMS\Product\Actions\ListProducts;
use App\FMS\Product\Actions\ShowProduct;
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
                'prefix' => 'api/products',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/', ListProducts::class);
            $router->get('/{product}', ShowProduct::class);
        });
    }
}
