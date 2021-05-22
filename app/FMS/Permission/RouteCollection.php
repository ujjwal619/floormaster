<?php

namespace App\FMS\Permission;

use App\FMS\Permission\Actions\ListPermissions;
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
                'prefix' => 'api/permissions',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/', ListPermissions::class);
        });
    }
}
