<?php

use Illuminate\Routing\Router;

/*
|--------------------------------------------------------------------------
| Front Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application frontend.
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/** @var Router $routes */

$routes->get(
    '/',
    function () {
        return redirect(route('admin.dashboard'));
    }
)->name('index');

$routes->get('/dashboard', 'Dashboard\DashboardController@index')->name('dashboard');

$routes->get('users/{status}/data-table', 'Users\UsersController@getPaginatedUsers')->name('users.table');
$routes->patch('users/{user}/status/{change}', 'Users\UsersController@changeStatus')->name('users.change.status');
$routes->get('/profile', 'Users\UsersController@profile')->name('users.profile');
$routes->get('/profile/edit', 'Users\UsersController@editProfile')->name('users.profile.edit');
$this->patch('user/{user}/change-password-admin', 'Users\UsersController@changePasswordByAdmin')->name('users.changePasswordAdmin');
$routes->patch('/profile', 'Users\UsersController@updateProfile')->name('users.profile.update');
$routes->resource('users', 'Users\UsersController');

$routes->get('roles/data-table', 'Users\RolesController@getPaginatedRoles')->name('roles.table');
$routes->resource('roles', 'Users\RolesController');

$routes->get('permissions/data-table', 'Users\Permissions\PermissionsController@getPaginatedPermissions')->name('permissions.table');
$routes->get('/permissions/manage', 'Users\Permissions\PermissionsController@showRolesAndPermissions')->name('permissions.manage');
$routes->get('/permissions/{permission}/role/{role}/toggle', 'Users\Permissions\PermissionsController@togglePermission')->name('permissions.toggle');
$routes->resource('/permissions', 'Users\Permissions\PermissionsController');

$routes->get('job-sources/data-table', 'JobSource\JobSourceController@getPaginatedJobSources')->name('job-sources.table');
$routes->resource('job-sources', 'JobSource\JobSourceController');

$routes->get('suppliers/data-table', 'Supplier\SupplierController@getPaginatedSuppliers')->name('suppliers.table');
$routes->resource('suppliers', 'Supplier\SupplierController');

$routes->get('customers/data-table', 'Customers\CustomerController@getPaginatedCustomers')->name('customers.table');
$routes->get('quotes/data-table', 'Customers\QuotesController@getPaginatedQuotes')->name('quotes.table');
$routes->post('quotes/{quote}/convert-to-job', 'Customers\QuotesController@convertQuoteToJob')->name('quotes.to_job');
$routes->resource('/quotes', 'Customers\QuotesController');
$routes->get('customers/{customerId}/details', 'Customers\CustomerController@getCustomerDetails')->name('customer.details');
$routes->get('customers/{customer}/latest-quote-id', 'Customers\CustomerController@getLatestQuoteId')->name('customer.latest.quote');

$routes->resource('customers', 'Customers\CustomerController');

/**
 * Memo
 */
// $routes->post('memos', 'Memo\MemoController@store')->name('memos.store');
// $routes->get('memos', 'Memo\MemoController@index')->name('memos.index');

/**
 * Routes for the jobs module
 */
$routes->get('jobs/data-table', 'Customers\JobController@getPaginatedJobs')->name('jobs.table');
$routes->resource('/jobs', 'Customers\JobController');
$routes->post('/jobs/{id}/invoice', 'Customers\JobController@addInvoice')->name('jobs.add-invoice');
$routes->get('/jobs/{job}/invoice/{invoice}/print', 'Customers\JobController@showInvoicePrint')->name('jobs.show-invoice-print');

/**
 * Routes for the product module.
 */

$routes->resource('products', 'Product\ProductController');

$routes->group(['prefix' => 'products', 'as' => 'products.'], function () use ($routes) {
    $routes->get('categories/data-table', 'Product\CategoryController@getPaginatedCategories')->name('categories.table');
    $routes->get('categories/{id}/details', 'Product\CategoryController@getDetails')->name('categories.details');
    $routes->resource('categories', 'Product\CategoryController')->except(['edit', 'show']);
    $routes->get('/type', 'Product\ProductTypeController@index')->name('type.index');
    $routes->get('{product_type}/data-table', 'Product\ProductTypeController@getPaginatedProducts')->name('type.table');
    $routes->get('/{product_type}/create', 'Product\ProductTypeController@create')->name('type.create');
    $routes->post('/{product_type}', 'Product\ProductTypeController@store')->name('type.store');
    $routes->get('/{product_type}/{product}', 'Product\ProductTypeController@show')->name('type.show');
    $routes->get('/{product_type}/{product}/edit', 'Product\ProductTypeController@edit')->name('type.edit');
    $routes->patch('/{product_type}/{product}', 'Product\ProductTypeController@update')->name('type.update');
    $routes->delete('/{product_type}/{product}', 'Product\ProductTypeController@delete')->name('type.destroy');

//    $routes->get('/{product_type}/{product}/stocks', 'Product\StocksController@index')->name('stocks.index');
//    $routes->post('{product_type}/{product}/stocks', 'Product\StocksController@store')->name('stocks.store');
});

$routes->get('terms/data-table', 'Settings\TermsController@getPaginatedTermsForTable')->name('terms.table');
$routes->resource('terms', 'Settings\TermsController');

/**
 * Routes for Templates Module
 */

$routes->resource('/templates', 'Template\TemplateController');

/**
 * Routes for Booking Module
 */

$routes->resource('bookings', 'Booking\BookingController', [
    'only' => ['index', 'store', 'update', 'destroy']
]);

/**
 * Routes for Booking Type Module
 */

$routes->resource('booking-types', 'Booking\BookingTypeController', [
    'only' => ['index', 'store', 'update', 'destroy']
]);

/**
 * Routes for Installation Complaints Module
 */

$routes->resource('installation-complaints', 'InstallationComplaint\InstallationComplaintController', [
    'only' => ['index', 'create', 'edit', 'store', 'update', 'destroy']
]);

$routes->group(['as' => 'stocks.'], function () use ($routes) {
    $routes->get('/stocks', 'Stock\StockController@redirect')->name('redirect');
    $routes->get('/color/{productVariant}/stocks', 'Stock\StockController@edit')->name('edit');
    $routes->put('/color/{colorId}/stocks', 'Stock\StockController@store')->name('store');
    $routes->post('/color/{colorId}/current-stocks', 'Stock\StockController@storeCurrentStocks')->name('current.store');
    $routes->post('/color/{colorId}/future-stocks', 'Stock\StockController@storeFutureStocks')->name('future.store');
    $routes->put('/color/{colorId}/current-stocks/{id}', 'Stock\StockController@updateCurrentStock')->name('current.update');
    $routes->put('/future-stocks/{id}', 'Stock\StockController@updateFutureStock')->name('future.update');
    $routes->post('/future-stocks', 'Stock\StockController@storeFutureStocks')->name('future.store');
    $routes->post('/future-stocks/{futureStockId}/order-receipt', 'Stock\StockController@createOrderReceipt')->name('future.orderReceipt');
    $routes->post('/future-stocks/{futureStockId}/delivery-orders', 'Stock\StockController@createDeliveryOrders')->name('future.deliveryOrders');
    $routes->delete('future-stocks/{id}', 'Stock\StockController@deleteFutureStock');
});

$routes->group(['as' => 'currentOrders.'], function () use ($routes) {
    $routes->get('/current-orders', 'Stock\CurrentOrderController@redirect')->name('redirect');
    $routes->get('/current-orders/{id}', 'Stock\CurrentOrderController@edit')->name('edit');
});

$routes->get('/setup', function () {
    return view('admin.modules.setup.index');
});

$routes->group(['as' => 'setup.'], function () use ($routes) {
    $routes->get('/setup', 'Settings\SetupController@index')->name('index');
    $routes->put('/setup', 'Settings\SetupController@save')->name('store');
});

$routes->get('/accounts', function () {
    return view('admin.modules.accounts.index');
});

$routes->get('/transaction-journals', function () {
    return view('admin.modules.transaction-journals.index');
});

$routes->group(['as' => 'accounts.'], function () use ($routes) {
    $routes->get('/accounts/{family}/sites/{site}', 'Account\AccountController@family')->name('family');
    $routes->get('/accounts', 'Account\AccountController@index')->name('index');
    $routes->post('/accounts', 'Account\AccountController@store')->name('store');
    $routes->put('/accounts/{id}', 'Account\AccountController@update')->name('update');
});

$routes->resource('/contractors', 'Contractor\ContractorController');

$routes->post('/contractors/{id}/payments', 'Contractor\ContractorController@storePayment')->name('contractors.payment.add');
$routes->get('/contractors/{id}/payments', 'Contractor\ContractorController@payments')->name('contractors.payment');

$routes->get('/billings', function () {
    return view('admin.modules.billings.index');
});
$routes->get('/work-in-progress', function () {
    return view('admin.modules.work-in-progress.index');
});
$routes->get('/billings/print', function () {
    return view('admin.modules.billings.print');
});

$routes->post('/jobs/{id}/receipts', 'Customers\JobController@addReceipt')->name('invoice.receipt.add');
$routes->get('/jobs/{job}/invoices', 'Customers\JobController@invoices')->name('job.invoices');
$routes->get('/jobs/{id}/non-allocated-receipts', 'Customers\JobController@nonAllocatedReceipts')->name('job.non.allocated.receipts');
$routes->get('/jobs/{id}/receipts', 'Customers\JobController@receipts')->name('job.receipts');

$routes->get('/security', function () {
    return view('admin.modules.security.index');
});

$routes->get('/memos', function () {
    return view('admin.modules.memos.index');
});

$routes->get('/clients', function () {
    return view('admin.modules.clients.index');
});
$routes->get('/cheque-butt', function () {
    return view('admin.modules.chequeButt.index');
});
$routes->get('/stock-allocations', function () {
    return view('admin.modules.stock-allocations.index');
});
$routes->get('/action-required', function () {
    return view('admin.modules.action-required.index');
});
$routes->get('/costing-templates', function () {
    return view('admin.modules.costing-templates.index');
});
$routes->group(['middleware' => ['permission:payables']], function() use ($routes) {
    $routes->get('/payables', function () {
        return view('admin.modules.payables.index');
    });
});
$routes->get('/cash-book', function () {
    return view('admin.modules.cash-book.index');
});

$routes->group(['prefix' => '/reports'], function($routes) {
    $routes->get('/job', function() {
        return view('admin.modules.reports.job.index');
    });
    $routes->get('/supplier', function() {
        return view('admin.modules.reports.supplier.index');
    });
    $routes->get('/product', function() {
        return view('admin.modules.reports.product.index');
    });
});

$routes->get('/bank-reconciliation', function () {
    return view('admin.modules.bank-reconciliation.index');
});

$routes->get('/delivered-orders', function () {
    return view('admin.modules.delivered-orders.index');
});

