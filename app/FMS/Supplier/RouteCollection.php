<?php
/**
 * Created by PhpStorm.
 * User: manjul
 * Date: 8/2/19
 * Time: 8:23 PM
 */

namespace App\FMS\Supplier;


use App\FMS\Supplier\Actions\AccountDropdownForSupplier;
use App\FMS\Supplier\Actions\CreateColor;
use App\FMS\Supplier\Actions\CreateSupplierPayables;
use App\FMS\Supplier\Actions\DeleteSupplier;
use App\FMS\Supplier\Actions\DeleteSupplierPayable;
use App\FMS\Supplier\Actions\ExportSuppliersReport;
use App\FMS\Supplier\Actions\IndexSupplier;
use App\FMS\Supplier\Actions\IndexSupplierPayable;
use App\FMS\Supplier\Actions\ListColorsByProduct;
use App\FMS\Supplier\Actions\ListPayables;
use App\FMS\Supplier\Actions\ListProductsBySupplier;
use App\FMS\Supplier\Actions\ListSupplierPayablesBySite;
use App\FMS\Supplier\Actions\ListSuppliers;
use App\FMS\Supplier\Actions\ListSuppliersBySite;
use App\FMS\Supplier\Actions\ListSuppliersReport;
use App\FMS\Supplier\Actions\RemoveSupplierPayables;
use App\FMS\Supplier\Actions\ShowSupplier;
use App\FMS\Supplier\Actions\ShowSupplierPayable;
use App\FMS\Supplier\Actions\UpdateSupplierPayable;
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
                'prefix' => 'api/sites/{site}',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/suppliers', ListSuppliersBySite::class);
            $router->get('/suppliers/accounts', AccountDropdownForSupplier::class);
            $router->get('/payables', ListSupplierPayablesBySite::class);
        });

        $this->router->group(
            [
                'prefix' => 'api/suppliers',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/', IndexSupplier::class);
            $router->get('/list', ListSuppliers::class);
            $router->get('/report', ListSuppliersReport::class);
            $router->get('/report/export', ExportSuppliersReport::class);
            $router->get('/{supplier}', ShowSupplier::class);
            $router->delete('/{supplier}', DeleteSupplier::class);
            $router->get('/{supplier}/products', ListProductsBySupplier::class);
            $router->post('/{supplier}/payables', CreateSupplierPayables::class);
            $router->delete('/{supplier}/removePayables', RemoveSupplierPayables::class);
        });

        $this->router->group(
            [
                'prefix' => 'api/products/{product}/colors',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/', ListColorsByProduct::class);
            $router->post('/', CreateColor::class);
        });

        $this->router->group(
            [
                'prefix' => 'api/colors',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            // $router->put('/', ListColorsByProduct::class);
        });

        $this->router->group(
            [
                'prefix' => 'api/payables',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/', ListPayables::class);
            $router->get('/index', IndexSupplierPayable::class);
            $router->get('/{payable}', ShowSupplierPayable::class);
            $router->put('/{payable}', UpdateSupplierPayable::class);
            $router->delete('/{payable}', DeleteSupplierPayable::class);
        });
    }
}
