<?php

namespace Masrodjie\Queue\Libraries;

use CodeIgniter\Config\Services;
use Illuminate\Queue\Worker;
use Illuminate\Events\Dispatcher;
use Illuminate\Queue\Capsule\Manager as QueueManager;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Container\Container;
use Illuminate\Queue\WorkerOptions;
use Illuminate\Redis\RedisManager;
use Illuminate\Database\Capsule\Manager;

class Queue
{
    public $queue;

    public function __construct()
    {
        $queue = new QueueManager;
        $container = $queue->getContainer();
        $container['config'] = [
            'queue.connections.redis' => [
                'driver' => 'redis',
                'connection' => 'default',
                'queue' => 'default',
                'retry_after' => 30,
            ],
            'queue.default' => 'redis',
            'cache.default' => 'redis',
            'cache.stores.redis' => [
                'driver' => 'redis',
                'connection' => 'default'
            ],
            'cache.prefix' => 'illuminate_non_laravel',
            'database.redis' => [
                'cluster' => false,
                'default' => [
                    'host' => getenv('REDIS_HOST'),
                    'port' => getenv('REDIS_PORT'),
                    'database' => getenv('REDIS_DB'),
                ],
            ]
        ];

        $container['redis'] = new RedisManager(new \Masrodjie\Queue\Containers\Application, 'predis', $container['config']['database.redis']);

        $queue->setAsGlobal();
        $this->queue = $queue;

    }

    public function __call($method, $parameters)
    {
        return $this->queue->$method(...$parameters);
    }
}
