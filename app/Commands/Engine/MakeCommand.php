<?php

namespace PHLConsole\Commands\Engine;

use PHLConsole\Commands\GeneratorCommand;
use PHLConsole\Engine\Make\Generators\Command;

class MakeCommand extends GeneratorCommand
{
    /**
     * The command signature.
     */
    protected function signature(): string
    {
        return 'make:command';
    }

    /**
     * The command description.
     */
    protected function description(): string
    {
        return 'Create a new Artisan command';
    }

    /**
     * The generated file specification.
     */
    protected function specification(): string
    {
        return Command::class;
    }
}
