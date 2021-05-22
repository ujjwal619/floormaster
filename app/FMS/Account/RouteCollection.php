<?php

namespace App\FMS\Account;

use App\FMS\Account\Actions\DeleteAccount;
use App\FMS\Account\Actions\ListAccountBySite;
use App\FMS\Account\Actions\RebuildChartBalance;
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
                'prefix' => 'api/sites/{site}/accounts',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/', ListAccountBySite::class);
            $router->post('/rebuild', RebuildChartBalance::class);
        });

        $this->router->group(
            [
                'prefix' => 'api/accounts/{account}',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->delete('/', DeleteAccount::class);
        });
    }
}
