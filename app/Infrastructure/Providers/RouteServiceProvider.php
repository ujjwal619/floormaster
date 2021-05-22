<?php

namespace App\Infrastructure\Providers;

use App\FMS\Account\RouteCollection as AccountRouteCollection;
use App\FMS\CashBook\RouteCollection as CashBookRouteCollection;
use App\FMS\Client\RouteCollection as ClientRouteCollection;
use App\FMS\Color\RouteCollection as ColorRouteCollection;
use App\FMS\Contractor\RouteCollection as ContractorRouteCollection;
use App\FMS\CostingTemplate\RouteCollection as CostingTemplateRouteCollection;
use App\FMS\Invoice\RouteCollection as InvoiceRouteCollection;
use App\FMS\Job\RouteCollection as JobRouteCollection;
use App\FMS\Permission\RouteCollection as PermissionRouteCollection;
use App\FMS\Quote\RouteCollection as QuoteRouteCollection;
use App\FMS\PostCode\RouteCollection as PostCodeRouteCollection;
use App\FMS\Remittance\RouteCollection as RemittanceRouteCollection;
use App\FMS\SalesStaff\RouteCollection as SalesStaffRouteCollection;
use App\FMS\Site\RouteCollection as SiteRouteCollection;
use App\FMS\Shop\RouteCollection as ShopRouteCollection;
use App\FMS\Source\RouteCollection as SourceRouteCollection;
use App\FMS\State\RouteCollection as StateRouteCollection;
use App\FMS\Stock\RouteCollection as StockRouteCollection;
use App\FMS\Supplier\RouteCollection as SupplierRouteCollection;
use App\FMS\Booking\RouteCollection as BookingRouteCollection;
use App\FMS\Terms\RouteCollection as TermsRouteCollection;
use App\FMS\User\RouteCollection as UserRouteCollection;
use App\FMS\CurrentOrder\RouteCollection as CurrentOrderRouteCollection;
use App\FMS\DeliveryOrder\RouteCollection as DeliveryOrderRouteCollection;
use App\FMS\InstallationComplaint\RouteCollection as InstallationComplaintRouteCollection;
use App\FMS\Memo\RouteCollection as MemoRouteCollection;
use App\FMS\Product\RouteCollection as ProductRouteCollection;
use App\FMS\Reports\RouteCollection as ReportRouteCollection;
use App\FMS\TransactionJournal\RouteCollection as TransactionJournalCollection;
use App\FMS\ProductCategory\RouteCollection as ProductCategoryRouteCollection;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Routing\Router as ApiRoute;

/**
 * Class RouteServiceProvider
 * @package App\Infrastructure\Providers
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * These namespaces are applied to your controller routes.
     *
     * In addition, these are set as the URL generator's root namespace.
     *
     * @var array
     */
    protected $namespace = [
        'admin' => 'App\Domain\Admin\Controllers',
        'api'   => 'App\Domain\Api\Controllers',
        'auth'  => 'App\Domain\Auth\Controllers',
    ];

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @param Router   $routes
     * @param ApiRoute $api
     *
     * @return void
     */
    public function map(Router $routes, ApiRoute $api)
    {
        $this->mapAdminRoutes($routes);
        $this->mapApiRoutes($api);
        $this->mapAuthRoutes($routes);
    }

    /**
     * Define the "admin" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @param Router $routes
     *
     * @return void
     */
    protected function mapAdminRoutes(Router $routes)
    {
        $routes->group(
            [
                'namespace'  => $this->namespace['admin'],
                'middleware' => ['web', 'auth'],
                'as'         => 'admin.',
            ],
            function () use ($routes) {
                require_once base_path('routes/admin.php');
            }
        );
        (new SiteRouteCollection($routes))();
        (new UserRouteCollection($routes))();
        (new PermissionRouteCollection($routes))();
        (new TermsRouteCollection($routes))();
        (new SourceRouteCollection($routes))();
        (new SalesStaffRouteCollection($routes))();
        (new QuoteRouteCollection($routes))();
        (new JobRouteCollection($routes))();
        (new ClientRouteCollection($routes))();
        (new StateRouteCollection($routes))();
        (new SupplierRouteCollection($routes))();
        (new RemittanceRouteCollection($routes))();
        (new ContractorRouteCollection($routes))();
        (new StockRouteCollection($routes))();
        (new InvoiceRouteCollection($routes))();
        (new AccountRouteCollection($routes))();
        (new CashBookRouteCollection($routes))();
        (new CostingTemplateRouteCollection($routes))();
        (new CurrentOrderRouteCollection($routes))();
        (new DeliveryOrderRouteCollection($routes))();
        (new MemoRouteCollection($routes))();
        (new TransactionJournalCollection($routes))();
        (new ProductRouteCollection($routes))();
        (new ColorRouteCollection($routes))();
        (new BookingRouteCollection($routes))();
        (new ReportRouteCollection($routes))();
        (new ProductCategoryRouteCollection($routes))();
        (new ShopRouteCollection($routes))();
        (new PostCodeRouteCollection($routes))();
        (new InstallationComplaintRouteCollection($routes))();
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @param ApiRoute $api
     *
     * @return void
     */
    protected function mapApiRoutes(ApiRoute $api)
    {
        $api->group(
            [
                'namespace'  => $this->namespace['api'],
                'prefix'     => config('config.route_prefixes.api'),
                'middleware' => 'api',
                'as'         => 'api',
            ],
            function () use ($api) {
                require_once base_path('routes/api.php');
            }
        );
    }

    /**
     * Define the "auth" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @param Router $routes
     *
     * @return void
     */
    protected function mapAuthRoutes(Router $routes)
    {
        $routes->group(
            [
                'namespace'  => $this->namespace['auth'],
                'as'         => 'auth',
                'middleware' => 'web',
            ],
            function () use ($routes) {
                require_once base_path('routes/auth.php');
            }
        );
    }
}
