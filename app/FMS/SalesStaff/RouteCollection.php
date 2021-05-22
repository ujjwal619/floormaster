<?php

namespace App\FMS\SalesStaff;

use App\FMS\SalesStaff\Actions\CreateSalesStaff;
use App\FMS\SalesStaff\Actions\DeleteSalesStaff;
use App\FMS\SalesStaff\Actions\ListTemplates;
use App\FMS\SalesStaff\Actions\UpdateSalesStaff;
use App\FMS\SalesStaff\Actions\ListSalesStaff;
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
                'prefix' => 'api/sites/{site}/sales_staff',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->post('/', CreateSalesStaff::class);
            $router->get('/', ListSalesStaff::class);
        });

        $this->router->group(
            [
                'prefix' => 'api/sites/{site}/templates',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/', ListTemplates::class);
        });

        $this->router->group(
            [
                'prefix' => 'api/sales_staff',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->put('{salesStaff}/', UpdateSalesStaff::class);
            $router->delete('{salesStaff}/', DeleteSalesStaff::class);
        });
    }
}
