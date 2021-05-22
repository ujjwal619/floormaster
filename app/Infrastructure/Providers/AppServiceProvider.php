<?php

namespace App\Infrastructure\Providers;

use App\Data\Entities\Models\Job\Job;
use App\Data\Entities\Models\Product\ProductVariant;
use App\Data\Entities\Models\Quote\Quote;
use App\FMS\User\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

/**
 * Class AppServiceProvider
 * @package App\Infrastructure\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        $morphMap = [
            ProductVariant::MORPH_ALIAS => ProductVariant::class,
            Job::MORPH_ALIAS => Job::class,
            User::MORPH_ALIAS => User::class,
            Quote::MORPH_ALIAS => Quote::class,
            ProductVariant::MORPH_ALIAS => ProductVariant::class
        ];

        Relation::morphMap($morphMap);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Builder::macro('filter', function ($filters, ...$arguments) {
            if (is_callable($filters)) {
                $filters($this, ...$arguments);
            } else {
                $filters->apply($this, ...$arguments);
            }

            return $this;
        });
    }
}
