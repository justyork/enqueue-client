<?php

namespace Justyork\EnqueueClient;

use Justyork\EnqueueClient\Console\ConsumeMessages;
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
        $this->mergeConfigFrom(__DIR__ . '/config/enqueue_client.php', 'enqueue_client');

        $config = config('enqueue_client');
        $transport = $config['transports'][$config['transports']['default']];
        $className = $transport['class'];

        $this->app->bind($className, fn($app) => new $className($transport));
        $this->app->bind(Context::class, $className);
    }


    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ConsumeMessages::class
            ]);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/config/enqueue_client.php' => config_path('enqueue_client.php')], 'config');
        $this->publishes([__DIR__ . '/config/events_map.php' => config_path('events_map.php')], 'config');
        $this->registerCommands();
    }

    public function provides()
    {
        return [
            ConsumeMessages::class
        ];
    }
}
