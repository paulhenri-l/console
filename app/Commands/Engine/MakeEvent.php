<?php

namespace PHLConsole\Commands\Engine;

use PHLConsole\Commands\GeneratorCommand;
use PHLConsole\Engine\Make\Generators\Event;

class MakeEvent extends GeneratorCommand
{
    /**
     * The command signature.
     */
    protected function signature(): string
    {
        return 'make:event';
    }

    /**
     * The command description.
     */
    protected function description(): string
    {
        return 'Create a new event class';
    }

    /**
     * The generated file specification.
     */
    protected function specification(): string
    {
        return Event::class;
    }
}
