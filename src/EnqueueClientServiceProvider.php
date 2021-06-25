<?php

namespace Justyork\EnqueueClient;

use Enqueue\RdKafka\RdKafkaContext;
use Illuminate\Support\ServiceProvider;
use Interop\Queue\ConnectionFactory;
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
        //
    }
}
