<?php

namespace PHLConsole\Commands\Engine;

use PHLConsole\Commands\GeneratorCommand;
use PHLConsole\Engine\Make\Generators\Migration;

class MakeMigration extends GeneratorCommand
{
    /**
     * The command signature.
     */
    protected function signature(): string
    {
        return 'make:migration';
    }

    /**
     * The command description.
     */
    protected function description(): string
    {
        return 'Create a new migration file';
    }

    /**
     * The generated file specification.
     */
    protected function specification(): string
    {
        return Migration::class;
    }
}
