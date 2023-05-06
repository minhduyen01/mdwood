<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Queue;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            \App\Services\CategoryServiceInterface::class,
            \App\Services\CategoryService::class
        );

        $this->app->singleton(
            \App\Services\TypeProductServiceInterface::class,
            \App\Services\TypeProductService::class
        );

        $this->app->singleton(
            \App\Services\SupplierServiceInterface::class,
            \App\Services\SupplierService::class
        );

        $this->app->singleton(
            \App\Services\ProductServiceInterface::class,
            \App\Services\ProductService::class
        );

        $this->app->singleton(
            \App\Services\ImageServiceInterface::class,
            \App\Services\ImageService::class
        );

        $this->app->singleton(
            \App\Services\SlideServiceInterface::class,
            \App\Services\SlideService::class
        );

        $this->app->singleton(
            \App\Services\UserServiceInterface::class,
            \App\Services\UserService::class
        );

        $this->app->singleton(
            \App\Services\BillServiceInterface::class,
            \App\Services\BillService::class
        );

        $this->app->singleton(
            \App\Services\BillDetailServiceInterface::class,
            \App\Services\BillDetailService::class
        );

        $this->app->singleton(
            \App\Services\NewsServiceInterface::class,
            \App\Services\NewsService::class
        );

        $this->app->singleton(
            \App\Services\SaleServiceInterface::class,
            \App\Services\SaleService::class
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
