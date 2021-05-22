<?php

namespace App\FMS\TransactionJournal;

use App\FMS\TransactionJournal\Actions\ListTransactionJournal;
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
                'prefix' => 'api/sites/{site}/transaction-journals',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/', ListTransactionJournal::class);
        });
    }
}
