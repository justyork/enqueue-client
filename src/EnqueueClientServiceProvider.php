<?php

namespace Justyork\EnqueueClient;

use Illuminate\Support\ServiceProvider;
use Interop\Queue\Context;

class EnqueueClientServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/enqueue.php', 'enqueue');

        $config = config('enqueue');
        $transport = $config['transports'][$config['transports']['default']];
        $className = $transport['class'];

        $this->app->bind($className, fn($app) => new $className($transport));
        $this->app->bind(Context::class, $className);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__.'/config/enqueue.php' => config_path('enqueue.php')], 'config');
    }
}
