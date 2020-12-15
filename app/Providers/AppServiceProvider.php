<?php

namespace App\Providers;

use App\Decorators\CurrencyCOPDecorator;
use App\Decorators\CurrencyUSDDecorator;
use App\Decorators\PriceFormatter;
use App\Decorators\PriceFormatterContract;
use App\Services\{PlacetoPayService, PlacetoPayServiceInterface};
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
            Client::class,
            function () {
                return new Client();
            }
        );
    }

    /**
     *
     */
    public function boot()
    {
        $this->app->bind(PriceFormatterContract::class, function(){
            $formatter = new PriceFormatter();

            switch(config('app.currency')){
                case 'USD':
                    return New CurrencyUSDDecorator($formatter);
                case 'COP':
                    return New CurrencyCOPDecorator($formatter);
            }

            return $formatter;
        });
    }
}
