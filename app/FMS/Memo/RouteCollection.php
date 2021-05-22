<?php

namespace App\FMS\Memo;

use App\FMS\Memo\Actions\CreateMemo;
use App\FMS\Memo\Actions\DeleteMemo;
use App\FMS\Memo\Actions\ListMemoByUser;
use App\FMS\Memo\Actions\UpdateMemo;
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
                'prefix' => 'api/memos',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->post('/', CreateMemo::class);
            $router->put('/{memo}', UpdateMemo::class);
            $router->delete('/{memo}', DeleteMemo::class);
        });

        $this->router->group(
            [
                'prefix' => 'api/users',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/{user}/memos', ListMemoByUser::class);
        });
    }
}
