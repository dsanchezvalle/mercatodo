<?php

namespace App\Providers;

use App\Services\PlacetoPayService;
use App\Services\PlacetoPayServiceInterface;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PlacetoPayServiceInterface::class, PlacetoPayService::class);
        $this->app->singleton(
            Client::class, function () {
                return new Client();
            }
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
