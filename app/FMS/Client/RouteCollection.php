<?php

namespace App\FMS\Client;

use App\FMS\Client\Actions\CreateClient;
use App\FMS\Client\Actions\IndexClient;
use App\FMS\Client\Actions\ListClientBySite;
use App\FMS\Client\Actions\ListClients;
use App\FMS\Client\Actions\ListRelatedJobs;
use App\FMS\Client\Actions\ShowClient;
use App\FMS\Client\Actions\UpdateClient;
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
                'prefix' => 'api/sites/{site}/clients',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->post('/', CreateClient::class);
            $router->get('/', ListClientBySite::class);
        });

        $this->router->group(
            [
                'prefix' => 'api/clients',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/index', IndexClient::class);
            $router->put('{customer}/', UpdateClient::class);
            $router->get('{customer}/', ShowClient::class);
            $router->get('{customer}/jobs', ListRelatedJobs::class);
            $router->get('/', ListClients::class);
        });
    }
}
