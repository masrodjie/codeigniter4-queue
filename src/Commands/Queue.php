<?php

namespace Masrodjie\Queue\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Illuminate\Queue\Worker;
use Illuminate\Events\Dispatcher;
use Illuminate\Queue\Capsule\Manager as QueueManager;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Container\Container;
use Illuminate\Queue\WorkerOptions;
use Illuminate\Redis\RedisManager;

class Queue extends BaseCommand
{
    protected $group       = 'Illuminate';
    protected $name        = 'queue:work';
    protected $description = 'Run queue worker';

    public function run(array $params)
    {
        echo "Start Worker\n";

        $queue = service('queue');
        $dispatcher = new Dispatcher();
        $exception = new \Masrodjie\Queue\Exceptions\Handler();
        $isDownForMaintenance = function () {
            return false;
        };
        $worker = new Worker($queue->getQueueManager(), $dispatcher, $exception, $isDownForMaintenance, null);
        $options = new WorkerOptions();
        $options->maxTries = 5;
        $options->timeOut = 300;
        $worker->daemon('redis', 'default', $options);

    }
}
