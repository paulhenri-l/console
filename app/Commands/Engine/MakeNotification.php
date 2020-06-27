<?php

namespace PHLConsole\Commands\Engine;

use PHLConsole\Commands\GeneratorCommand;
use PHLConsole\Engine\Make\Generators\Notification;

class MakeNotification extends GeneratorCommand
{
    /**
     * The command signature.
     */
    protected function signature(): string
    {
        return 'make:notification';
    }

    /**
     * The command description.
     */
    protected function description(): string
    {
        return 'Create a new notification class';
    }

    /**
     * The generated file specification.
     */
    protected function specification(): string
    {
        return Notification::class;
    }
}
