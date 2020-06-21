<?php

namespace PHLConsole\Commands\Engine;

use PHLConsole\Commands\GeneratorCommand;
use PHLConsole\Engine\Make\Generators\Channel;

class MakeChannel extends GeneratorCommand
{
    /**
     * The command signature.
     */
    protected function signature(): string
    {
        return 'make:channel';
    }

    /**
     * The command description.
     */
    protected function description(): string
    {
        return 'Create a new channel class';
    }

    /**
     * The generated file specification.
     */
    protected function specification(): string
    {
        return Channel::class;
    }
}
