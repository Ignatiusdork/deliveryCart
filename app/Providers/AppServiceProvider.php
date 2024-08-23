<?php

namespace App\Providers;

use App\Services\CartService;
use App\Services\OrderService;
use App\Services\PaymentService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(OrderService::class, function ($app) {
            return new OrderService($app->make(CartService::class));

        });

        $this->app->singleton(CartService::class, function ($app) {
            return new CartService();
        });

        // $this->app->singleton(PaymentService::class, function ($app) {
        //     return new PaymentService($app->make(PaymentService::class));
        // });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
