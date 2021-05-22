<?php

namespace App\FMS\Color;

use App\FMS\Color\Actions\ListColors;
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
                'prefix' => 'api/colors',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/', ListColors::class);
        });
    }
}
