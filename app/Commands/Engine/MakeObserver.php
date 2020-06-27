<?php

namespace PHLConsole\Commands\Engine;

use PHLConsole\Commands\GeneratorCommand;
use PHLConsole\Engine\Make\Generators\Notification;

class MakeObserver extends GeneratorCommand
{
    /**
     * The command signature.
     */
    protected function signature(): string
    {
        return 'make:observer';
    }

    /**
     * The command description.
     */
    protected function description(): string
    {
        return 'Create a new observer class';
    }

    /**
     * The generated file specification.
     */
    protected function specification(): string
    {
        return Notification::class;
    }
}
