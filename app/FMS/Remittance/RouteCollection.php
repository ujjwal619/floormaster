<?php

namespace App\FMS\Remittance;

use App\FMS\Remittance\Actions\CreateRemittance;
use App\FMS\Remittance\Actions\CreateRemittanceItem;
use App\FMS\Remittance\Actions\DeleteRemittance;
use App\FMS\Remittance\Actions\IndexRemittance;
use App\FMS\Remittance\Actions\ListRemittanceBySite;
use App\FMS\Remittance\Actions\RemitRemittance;
use App\FMS\Remittance\Actions\ShowRemittance;
use App\FMS\Remittance\Actions\UpdateRemittance;
use App\FMS\Remittance\Actions\UpdateRemittanceItem;
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
                'prefix' => 'api/remittances',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/', IndexRemittance::class);
            $router->put('/{remittance}/remit', RemitRemittance::class);
            $router->delete('/{remittance}/', DeleteRemittance::class);
        });

        $this->router->group(
            [
                'prefix' => 'api/sites/{site}/remittances',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->post('/', CreateRemittance::class);
            $router->get('/', ListRemittanceBySite::class);
        });

        $this->router->group(
            [
                'prefix' => 'api/remittances/{remittance}',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->post('/items', CreateRemittanceItem::class);
            $router->put('/items/{remittanceItem}', UpdateRemittanceItem::class);
            $router->put('/', UpdateRemittance::class);
            $router->get('/', ShowRemittance::class);
        });
    }
}
