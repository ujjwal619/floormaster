<?php

namespace App\FMS\Source;

use App\FMS\Source\Actions\CreateSource;
use App\FMS\Source\Actions\DeleteSource;
use App\FMS\Source\Actions\ListSource;
use App\FMS\Source\Actions\UpdateSource;
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
                'prefix' => 'api/sites/{site}/sources',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/', ListSource::class);
            $router->post('/', CreateSource::class);
        });

        $this->router->group(
            [
                'prefix' => 'api/sources/{jobSource}',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->put('/', UpdateSource::class);
            $router->delete('/', DeleteSource::class);
        });
    }
}
