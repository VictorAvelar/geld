<?php

namespace VictorAvelar\Geld;

use Illuminate\Support\ServiceProvider;
use VictorAvelar\Fixer\FixerHttpClient;
use VictorAvelar\Fixer\Resources\LatestRatesResource;
use VictorAvelar\Geld\Commands\UpdateExchangeRatesCommand;

/**
 * Class GeldServiceProvider
 *
 * @package VictorAvelar\Geld
 * @author Victor Avelar <deltatuts@gmail.com>
 */
class GeldServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        // configuration
        $this->publishes([
            __DIR__ . '/../config/geld.php' => config_path('geld.php')
        ]);

        // migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                UpdateExchangeRatesCommand::class,
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/geld.php',
            'geld'
        );

        $this->app->singleton(FixerHttpClient::class, function () {
            return new FixerHttpClient(config("geld.access_key"));
        });

        $this->app->singleton(LatestRatesResource::class, function ($app) {
            return new LatestRatesResource($app->make(FixerHttpClient::class));
        });
    }
}
