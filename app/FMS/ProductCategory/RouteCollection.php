<?php

namespace App\FMS\ProductCategory;

use App\FMS\ProductCategory\Actions\ListCategories;
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
                'prefix' => 'api/categories',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/', ListCategories::class);
        });
    }
}
