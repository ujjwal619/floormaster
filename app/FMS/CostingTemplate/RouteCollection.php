<?php

namespace App\FMS\CostingTemplate;

use App\FMS\CostingTemplate\Actions\CreateTemplate;
use App\FMS\CostingTemplate\Actions\DeleteTemplate;
use App\FMS\CostingTemplate\Actions\IndexTemplate;
use App\FMS\CostingTemplate\Actions\ShowTemplate;
use App\FMS\CostingTemplate\Actions\UpdateTemplate;
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
                'prefix' => 'api/sites/{site}/templates',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->post('/', CreateTemplate::class);
        });

        $this->router->group(
            [
                'prefix' => 'api/templates',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/index', IndexTemplate::class);
            $router->get('/{template}', ShowTemplate::class);
            $router->put('/{template}', UpdateTemplate::class);
            $router->delete('/{template}', DeleteTemplate::class);
        });
    }
}
