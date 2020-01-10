<?php

namespace SmartContact\AdminPanel;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;

class AdminPanelServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadHelpers();
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'adminpanelgenerator');
        $this->publishes([
            __DIR__ . '/resources/js' => resource_path('js'),
            __DIR__ . '/resources/views' => resource_path('views/smartcontact/adminpanelgenerator'),
        ]);
    }

    public function boot()
    {
        try {
            $this->app->make('SmartContact\AdminPanel\controllers\AdminPanelPageController');
            $this->app->make('SmartContact\AdminPanel\requests\AdminPanelPageRequest');
        } catch (BindingResolutionException $e) {
        }

        if (file_exists(app_path('src/helpers.php'))) {
            require app_path('src/helpers.php');
        }
    }

    protected function loadHelpers()
    {
        foreach (glob(__DIR__.'/helpers.php') as $filename)
        {
            require_once $filename;
        }
    }
}
