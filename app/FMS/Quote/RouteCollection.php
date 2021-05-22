<?php

namespace App\FMS\Quote;

use App\FMS\Quote\Actions\CreateMemoForQuote;
use App\FMS\Quote\Actions\DeleteQuote;
use App\FMS\Quote\Actions\ListQuoteBySite;
use App\FMS\Quote\Actions\ListQuote;
use App\FMS\Quote\Actions\UpdateQuote;
use App\FMS\Quote\Actions\UpdateQuoteToJob;
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
                'prefix' => 'api/quotes',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/', ListQuote::class);
            $router->post('/{quote}/convert-to-job', UpdateQuoteToJob::class);
            $router->put('/{quote}', UpdateQuote::class);
            $router->delete('/{quote}', DeleteQuote::class);
            $router->post('/{quote}/memos', CreateMemoForQuote::class);
        });

        $this->router->group(
            [
                'prefix' => '/api/sites/{site}/quotes',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/', ListQuoteBySite::class);
        });
    }
}
