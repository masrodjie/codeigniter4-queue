<?php

namespace Masrodjie\Queue\Containers;

use Illuminate\Container\Container;
use Illuminate\Queue\Capsule\Manager as QueueManager;

class Application extends Container
{
    public function isDownForMaintenance()
    {
        return false;
    }
}
