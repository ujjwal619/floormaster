<?php

namespace App\FMS\Invoice;

use App\FMS\Invoice\Actions\CreateInvoiceExpense;
use App\FMS\Invoice\Actions\IndexInvoice;
use App\FMS\Invoice\Actions\ListInvoices;
use App\FMS\Invoice\Actions\ListInvoicesBySite;
use App\FMS\Invoice\Actions\ShowInvoice;
use App\FMS\Invoice\Actions\UpdateRetention;
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
                'prefix' => 'api/sites/{site}/invoices',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/', ListInvoicesBySite::class);
        });

        $this->router->group(
            [
                'prefix' => 'api/invoices',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/index', IndexInvoice::class);
            $router->get('/', ListInvoices::class);
            $router->get('/{invoice}', ShowInvoice::class);
            $router->post('/{invoice}/expenses', CreateInvoiceExpense::class);
            $router->put('/{invoice}/retention', UpdateRetention::class);
        });
    }
}
