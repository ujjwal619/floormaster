<?php

namespace App\FMS\Contractor;

use App\FMS\Contractor\Actions\EditPaymentsDue;
use App\FMS\Contractor\Actions\ListContractorBySite;
use App\FMS\Contractor\Actions\RemoveContractorPayments;
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
                'prefix' => 'api/sites/{site}/contractors',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/', ListContractorBySite::class);
        });

        $this->router->group(
            [
                'prefix' => 'api/contractors/{contractor}',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->delete('/removePayments', RemoveContractorPayments::class);
            $router->put('/payments/{paymentsDue}', EditPaymentsDue::class);
        });

    }
}
