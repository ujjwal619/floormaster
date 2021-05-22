<?php

namespace App\FMS\User;

use App\FMS\User\Actions\CreateUser;
use App\FMS\User\Actions\GetFirstAllowedSite;
use App\FMS\User\Actions\ListPermissions;
use App\FMS\User\Actions\ListUser;
use App\FMS\User\Actions\ShowCurrentUser;
use App\FMS\User\Actions\ShowUser;
use App\FMS\User\Actions\UpdateUser;
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
                'prefix' => 'api/users',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->post('/', CreateUser::class);
            $router->get('/me', ShowCurrentUser::class);
            $router->get('/{userId}', ShowUser::class);
            $router->get('/{userId}/permissions', ListPermissions::class);
            $router->get('/', ListUser::class);
            $router->put('/{userId}', UpdateUser::class);
        });

        $this->router->group(
            [
                'prefix' => 'api',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/my-first-allowed-site', GetFirstAllowedSite::class);
        });
    }
}
