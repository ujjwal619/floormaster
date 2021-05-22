<?php

namespace App\FMS\State;

use App\FMS\State\Actions\ListStates;
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
                'prefix' => 'api/states',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/', ListStates::class);
        });
    }
}
