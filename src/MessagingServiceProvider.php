<?php
namespace Bodyansky\Plivo;

use Illuminate\Support\ServiceProvider;
use Bodyansky\Plivo\Services\Messaging;
use Bodyansky\Plivo\Services\Plivo;


class MessagingServiceProvider extends ServiceProvider
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
     * @codeCoverageIgnore
     */
    public function boot()
    {

        $this->publishes([
            __DIR__ . '/../config/plivo.php' => config_path('plivo.php')
        ]);
        $this->mergeConfigFrom(__DIR__ . '/../config/plivo.php', 'plivo');
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('bodyansky.plivo', function ($app) {
            return new Messaging($app->make(Plivo::class));
        });

        $this->app->alias('bodyansky.plivo', 'Bodyansky\Plivo\Contracts\Services\Messaging');

        foreach (glob(__DIR__ . '/Helpers/*.php') as $filename) {
            require_once($filename);
        }

    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['bodyansky.plivo', 'Bodyansky\Plivo\Contracts\Services\Messaging'];
    }
}