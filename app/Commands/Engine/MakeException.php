<?php

namespace PHLConsole\Commands\Engine;

use PHLConsole\Commands\GeneratorCommand;
use PHLConsole\Engine\Make\Generators\Event;
use PHLConsole\Engine\Make\Generators\Exception;

class MakeException extends GeneratorCommand
{
    /**
     * The command signature.
     */
    protected function signature(): string
    {
        return 'make:exception';
    }

    /**
     * The command description.
     */
    protected function description(): string
    {
        return 'Create a new custom exception class';
    }

    /**
     * The generated file specification.
     */
    protected function specification(): string
    {
        return Exception::class;
    }
}
