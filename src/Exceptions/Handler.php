<?php

namespace Masrodjie\Queue\Exceptions;

use Exception;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Throwable;

class Handler implements ExceptionHandler
{
    public function report(Throwable $e)
    {
        echo $e->getMessage();
    }

    public function shouldReport(Throwable $e)
    {
        return true;
    }

    public function render($request, Throwable $e)
    {
        return 'error.page';
    }

    public function renderForConsole($output, Throwable $e)
    {
        echo 'renderForConsole';
    }

}