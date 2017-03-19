<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * ユーティリティサービスプロバイダ
 */
class UtilityServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
                'utility',
                'App\Services\UtilityService'
        );
    }

}
