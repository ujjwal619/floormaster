<?php

namespace App\FMS\CashBook;

use App\FMS\CashBook\Actions\BulkUpdateCashBook;
use App\FMS\CashBook\Actions\CreateCashBook;
use App\FMS\CashBook\Actions\ListAvailableCashBookBySite;
use App\FMS\CashBook\Actions\ListBankReconciliationBySite;
use App\FMS\CashBook\Actions\ListCashBooksBySite;
use App\FMS\CashBook\Actions\UpdateCashBook;
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
                'prefix' => 'api/cash-books',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->post('/', CreateCashBook::class);
            $router->put('/bulk', BulkUpdateCashBook::class);
            $router->put('/{cashBook}', UpdateCashBook::class);
        });

        $this->router->group(
            [
                'prefix' => 'api/sites/{site}/cash-books',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/', ListCashBooksBySite::class);
            $router->get('/available', ListAvailableCashBookBySite::class);
        });

        $this->router->group(
            [
                'prefix' => 'api/sites/{site}/bank-reconciliations',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/', ListBankReconciliationBySite::class);
        });
    }
}
