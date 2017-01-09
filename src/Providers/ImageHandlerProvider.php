<?php

namespace Amostajo\LaravelImageHandler\Providers;

/**
 * Service provider for package.
 *
 * @author Alejandro Mostajo
 * @license MIT
 * @package Amostajo\LaravelImageHandler
 */

use Illuminate\Support\ServiceProvider;

class ImageHandlerProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Publish config files
        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('image.php'),
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerClass();

        $this->mergeConfig();
    }

    /**
     * Register the application class bindings.
     *
     * @return void
     */
    private function registerClass()
    {
        $this->app->bind('imageHandler', function ($app) {
            return new \Amostajo\LaravelImageHandler\Classes\ImageHandler($app);
        });
    }

    /**
     * Merges user's and entrust's configs.
     *
     * @return void
     */
    private function mergeConfig()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/config.php', 'image'
        );
    }

    /**
     * Get the services provided.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'imageHandler'
        ];
    }
}