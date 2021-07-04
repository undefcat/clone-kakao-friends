<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Undefcat\Product\Repositories\IProductRepository;
use Undefcat\Product\Repositories\ProductRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            IProductRepository::class,
            ProductRepository::class,
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
