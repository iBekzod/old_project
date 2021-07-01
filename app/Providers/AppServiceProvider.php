<?php

namespace App\Providers;

use App\HelperClasses\Translations;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(env('DEMO_MODE') != 'On'){
            \Debugbar::disable();
        }
        Translations::getInstance()->getTranslations();
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        //
//        $app->register(\KitLoong\MigrationsGenerator\MigrationsGeneratorServiceProvider::class);
    }
}
