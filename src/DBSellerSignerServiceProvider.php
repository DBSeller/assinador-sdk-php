<?php

namespace Dbseller\AssinadorSdkPhp;

use Illuminate\Support\ServiceProvider;

class DBSellerSignerServiceProvider extends ServiceProvider
{

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config.php' => config_path('dbsellersigner.php'),
        ], 'dbseller-signer-config');

        $this->publishes([
            __DIR__ . '/DBSellerSignerServiceProvider.php' => app_path('Providers/DBSellerSignerServiceProvider.php'),
        ], 'dbseller-signer-provider');
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     * @throws \Exception
     */
    public function register()
    {
        $this->app->singleton(DBSellerSigner::class, function ($app) {
            return new DBSellerSigner(config('dbsellersigner'));
        });
    }
}