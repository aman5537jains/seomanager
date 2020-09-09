<?php

namespace Aman\SeoManager;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Aman\SeoManager\SeoManager as SM;
class SeoManagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('seomanager', function ($expression) {
            $SM=new SM();
            
            if($expression=="add-form")
                return $SM->addView();
            else
                return $SM->listView();
            
        });
        $this->publishes([
            __DIR__.'/seoconfig.php' => config_path('seoconfig.php','seoconfig'),
        ]);
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'seomanager');
        // $this->publishes([
        //     __DIR__.'/views' => base_path('resources/views/aman'),
        // ]);
    
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/seoconfig.php' ,'seoconfig'
        );
        //   $this->app->make('Aman\SeoManagaer\Controllers\CrudController');
    }
}
