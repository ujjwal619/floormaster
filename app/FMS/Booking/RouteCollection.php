<?php
/**
 * Created by PhpStorm.
 * User: manjul
 * Date: 8/2/19
 * Time: 8:23 PM
 */

namespace App\FMS\Booking;

use App\FMS\Booking\Actions\ListBookings;
use App\FMS\Booking\Actions\ListBookingTypes;
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
                'prefix' => 'api/bookings',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/list', ListBookings::class);
        });

        $this->router->group(
            [
                'prefix' => 'api/booking-types',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/list', ListBookingTypes::class);
        });
    }
}
