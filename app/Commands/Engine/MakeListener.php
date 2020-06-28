<?php

namespace PHLConsole\Commands\Engine;

use PHLConsole\Commands\GeneratorCommand;
use PHLConsole\Engine\Make\Generators\Listener;

class MakeListener extends GeneratorCommand
{
    /**
     * The command signature.
     */
    protected function signature(): string
    {
        return 'make:listener';
    }

    /**
     * The command description.
     */
    protected function description(): string
    {
        return 'Create a new event listener class';
    }

    /**
     * The generated file specification.
     */
    protected function specification(): string
    {
        return Listener::class;
    }
}
