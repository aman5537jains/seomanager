<?php

namespace Aman5537jains\SeoManager;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Aman5537jains\SeoManager\SeoManager as SM;
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

        Blade::directive('seomanagertags', function ($expression) {
            $SM=new SM();
            return   '<?php $manager=new \Aman5537jains\SeoManager\SeoManager();
            $meta= $manager->getPageMeta()["havetag"];
                                echo "<title>$meta->meta_title</title>
                                <meta name=\'description\' content=\'$meta->meta_description\'>
                                <meta name=\'keywords\' content=\'$meta->meta_keyword\'>"; ?>';;
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
