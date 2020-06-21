<?php

namespace PHLConsole\Commands\Engine;

use PHLConsole\Commands\GeneratorCommand;
use PHLConsole\Engine\Make\Generators\Cast;

class MakeCast extends GeneratorCommand
{
    /**
     * The command signature.
     */
    protected function signature(): string
    {
        return 'make:cast';
    }

    /**
     * The command description.
     */
    protected function description(): string
    {
        return 'Create a new custom Eloquent cast class';
    }

    /**
     * The generated file specification.
     */
    protected function specification(): string
    {
        return Cast::class;
    }
}
