<?php

namespace App\FMS\Site;

use App\FMS\Site\Actions\CreateSite;
use App\FMS\Site\Actions\IsMySite;
use App\FMS\Site\Actions\ListProductBySite;
use App\FMS\Site\Actions\ListSite;
use App\FMS\Site\Actions\ListUsersBySite;
use App\FMS\Site\Actions\ShowSite;
use App\FMS\Site\Actions\UpdateSite;
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
                'prefix' => 'api/sites',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/', ListSite::class);
            $router->post('/', CreateSite::class);
            $router->get('/{site}', ShowSite::class);
            $router->put('/{site}', UpdateSite::class);
            $router->get('/{site}/is-my-site', IsMySite::class);

            $router->get('/{site}/products', ListProductBySite::class);
            $router->get('/{site}/users', ListUsersBySite::class);
        });
    }
}
