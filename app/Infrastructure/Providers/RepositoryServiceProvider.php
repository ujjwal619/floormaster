<?php

namespace App\Infrastructure\Providers;

use App\Data\Repositories\Account\AccountEloquentRepository;
use App\Data\Repositories\Account\AccountRepository;
use App\Data\Repositories\Booking\BookingEloquentRepository;
use App\Data\Repositories\Booking\BookingRepository;
use App\Data\Repositories\Booking\BookingTypeEloquentRepository;
use App\Data\Repositories\Booking\BookingTypeRepository;
use App\Data\Repositories\Contractor\ContractorEloquentRepository;
use App\Data\Repositories\Contractor\ContractorRepository;
use App\Data\Repositories\Customer\CategoryEloquentRepository;
use App\Data\Repositories\Customer\CustomerEloquentRepository;
use App\Data\Repositories\Customer\CustomerRepository;
use App\Data\Repositories\InstallationComplaint\InstallationComplaintEloquentRepository;
use App\Data\Repositories\InstallationComplaint\InstallationComplaintRepository;
use App\Data\Repositories\Job\InvoiceRepository;
use App\Data\Repositories\Job\JobRepository;
use App\Data\Repositories\JobSource\JobSourceEloquentRepository;
use App\Data\Repositories\JobSource\JobSourceRepository;
use App\Data\Repositories\Product\Labour\LabourProductEloquentRepository;
use App\Data\Repositories\Product\Material\MaterialProductEloquentRepository;
use App\Data\Repositories\Product\Category\CategoryRepository;
use App\Data\Repositories\Product\Labour\LabourProductRepository;
use App\Data\Repositories\Product\Material\MaterialProductRepository;
use App\Data\Repositories\Product\ProductEloquentRepository;
use App\Data\Repositories\Product\ProductRepository;
use App\Data\Repositories\Product\ProductVariantEloquentRepository;
use App\Data\Repositories\Product\ProductVariantRepository;
use App\Data\Repositories\Quote\InvoiceEloquentRepository;
use App\Data\Repositories\Job\JobEloquentRepository;
use App\Data\Repositories\Quote\QuoteEloquentRepository;
use App\Data\Repositories\Quote\QuoteRepository;
use App\Data\Repositories\Settings\SetupEloquentRepository;
use App\Data\Repositories\Settings\SetupRepository;
use App\Data\Repositories\Settings\Terms\TermsEloquentRepository;
use App\Data\Repositories\Settings\Terms\TermsRepository;
use App\Data\Repositories\Stock\CurrentOrderEloquentRepository;
use App\Data\Repositories\Stock\CurrentOrderRepository;
use App\Data\Repositories\Stock\CurrentStockEloquentRepository;
use App\Data\Repositories\Stock\CurrentStockRepository;
use App\Data\Repositories\Stock\FutureStockEloquentRepository;
use App\Data\Repositories\Stock\FutureStockRepository;
use App\Data\Repositories\Stock\OrderReceiptEloquentRepository;
use App\Data\Repositories\Stock\OrderReceiptRepository;
use App\Data\Repositories\Stock\StockEloquentRepository;
use App\Data\Repositories\Stock\StockRepository;
use App\Data\Repositories\Supplier\SupplierEloquentRepository;
use App\Data\Repositories\Supplier\SupplierRepository;
use App\Data\Repositories\Template\TemplateEloquentRepository;
use App\Data\Repositories\Template\TemplateRepository;
use App\Data\Repositories\User\Permission\PermissionEloquentRepository;
use App\Data\Repositories\User\Permission\PermissionRepository;
use App\Data\Repositories\User\Role\RoleEloquentRepository;
use App\Data\Repositories\User\Role\RoleRepository;
use App\Data\Repositories\User\UserEloquentRepository;
use App\Data\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider
 * @package App\Infrastructure\Providers
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $repositories = [
        UserRepository::class                   => UserEloquentRepository::class,
        PermissionRepository::class             => PermissionEloquentRepository::class,
        RoleRepository::class                   => RoleEloquentRepository::class,
        JobSourceRepository::class              => JobSourceEloquentRepository::class,
        CustomerRepository::class               => CustomerEloquentRepository::class,
        SupplierRepository::class               => SupplierEloquentRepository::class,
        CategoryRepository::class               => CategoryEloquentRepository::class,
        MaterialProductRepository::class        => MaterialProductEloquentRepository::class,
        LabourProductRepository::class          => LabourProductEloquentRepository::class,
        QuoteRepository::class                  => QuoteEloquentRepository::class,
        JobRepository::class                    => JobEloquentRepository::class,
        TermsRepository::class                  => TermsEloquentRepository::class,
        TemplateRepository::class               => TemplateEloquentRepository::class,
        BookingRepository::class                => BookingEloquentRepository::class,
        BookingTypeRepository::class            => BookingTypeEloquentRepository::class,
        InstallationComplaintRepository::class  => InstallationComplaintEloquentRepository::class,
        ProductRepository::class                => ProductEloquentRepository::class,
        StockRepository::class                  => StockEloquentRepository::class,
        CurrentStockRepository::class           => CurrentStockEloquentRepository::class,
        CurrentOrderRepository::class           => CurrentOrderEloquentRepository::class,
        ProductVariantRepository::class         => ProductVariantEloquentRepository::class,
        FutureStockRepository::class            => FutureStockEloquentRepository::class,
        OrderReceiptRepository::class           => OrderReceiptEloquentRepository::class,
        SetupRepository::class                  => SetupEloquentRepository::class,
        AccountRepository::class                => AccountEloquentRepository::class,
        ContractorRepository::class             => ContractorEloquentRepository::class,
        InvoiceRepository::class                => InvoiceEloquentRepository::class
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        collect($this->repositories)->each(function (string $implementation, string $interface) {
            $this->app->bind($interface, $implementation);
        });
    }
}
