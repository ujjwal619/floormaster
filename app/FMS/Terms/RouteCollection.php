<?php

namespace App\FMS\Terms;

use App\FMS\Terms\Actions\ListTermsBySite;
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
                'prefix' => 'api/sites/{site}/terms',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/', ListTermsBySite::class);
        });

        $this->router->group(
            [
                'prefix' => 'api/terms/{$termsAndCondition}',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/', ListTermsBySite::class);
        });
    }
}
