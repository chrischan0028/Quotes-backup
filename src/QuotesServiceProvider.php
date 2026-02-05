<?php
namespace MyVendor\Quotes;

use Illuminate\Support\ServiceProvider;
use MyVendor\Quotes\Console\Commands\BatchImportQuotes;

class QuotesServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/quotes.php', 'quotes');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/quotes.php' => config_path('quotes.php')
        ], 'config');

        $this->publishes([
            __DIR__.'/../resources/js' => public_path('vendor/quotes/js'),
        ], 'assets');

        $this->publishes([
            __DIR__.'/../dist' => public_path('vendor/quotes/dist'),
        ], 'assets');

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        if ($this->app->runningInConsole()) {
            $this->commands([
                BatchImportQuotes::class,
            ]);
        }
    }
}
