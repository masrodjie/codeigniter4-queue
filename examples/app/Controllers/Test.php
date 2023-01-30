<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Test extends BaseController
{
    public function index()
    {
        $this->queue->push('\App\Jobs\SendEmail', ['to' => 'me@example.com']);
        return 'OK';
    }
}
