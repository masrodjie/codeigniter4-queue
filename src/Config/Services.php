<?php

namespace Masrodjie\Queue\Config;

use CodeIgniter\Config\BaseService as CoreServices;
use Masrodjie\Queue\Libraries\Queue;

class Services extends CoreServices
{
    public static function queue($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('queue');
        }

        return new Queue();
    }
}