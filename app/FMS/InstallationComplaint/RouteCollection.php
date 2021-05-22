<?php

namespace App\FMS\InstallationComplaint;

use App\FMS\InstallationComplaint\Actions\ListInstallationComplaint;
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
                'prefix' => 'api/installation-complaints',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/', ListInstallationComplaint::class);
        });
    }
}
