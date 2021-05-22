<?php

namespace App\FMS\PostCode;

use App\FMS\Permission\Actions\ListPermissions;
use App\FMS\PostCode\Actions\ListAustraliaPostCodes;
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
                'prefix' => 'api/australia/postcodes',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/', ListAustraliaPostCodes::class);
        });
    }
}
