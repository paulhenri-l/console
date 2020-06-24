<?php

namespace PHLConsole\Commands\Engine;

use PHLConsole\Commands\GeneratorCommand;
use PHLConsole\Engine\Make\Generators\Mail;
use PHLConsole\Engine\Make\Generators\Middleware;

class MakeMiddleware extends GeneratorCommand
{
    /**
     * The command signature.
     */
    protected function signature(): string
    {
        return 'make:middleware';
    }

    /**
     * The command description.
     */
    protected function description(): string
    {
        return 'Create a new middleware class';
    }

    /**
     * The generated file specification.
     */
    protected function specification(): string
    {
        return Middleware::class;
    }
}
