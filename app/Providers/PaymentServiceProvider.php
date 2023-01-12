<?php

namespace App\Providers;

use App\Interface\PaymentServiceInterface;
use App\Services\PaypalAPI;
use App\Services\PayuAPI;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind(PaypalAPI::class, function () {
        //     return new PaypalAPI(rand(0, 1500));
        // });
        $this->app->bind(PaymentServiceInterface::class, PayuAPI::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function provides(): array
    {
        return [PaypalAPI::class];
    }
}
