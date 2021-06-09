<?php

namespace App\Providers;

use App\HelperClasses\Translations;
use App\Services\NormalDependency;
use App\Services\SingleTonDependency;
use App\Services\ViaInterfaceDependency;
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
        // \Debugbar::disable();
        Translations::getInstance()->getTranslations();
//        \Debugbar::disable();
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(NormalDependency::class,function($app){
            return new NormalDependency();
        });

        $this->app->singleton(SingleTonDependency::class,function($app){
           return new SingleTonDependency();
        });

        $this->app->bind(ExampleContract::class,function($app){
           return new ViaInterfaceDependency();
        });
        //
//        $app->register(\KitLoong\MigrationsGenerator\MigrationsGeneratorServiceProvider::class);
    }
}
