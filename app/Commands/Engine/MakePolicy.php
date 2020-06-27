<?php

namespace PHLConsole\Commands\Engine;

use PHLConsole\Commands\GeneratorCommand;
use PHLConsole\Engine\Make\Generators\Policy;

class MakePolicy extends GeneratorCommand
{
    /**
     * The command signature.
     */
    protected function signature(): string
    {
        return 'make:policy';
    }

    /**
     * The command description.
     */
    protected function description(): string
    {
        return 'Create a new policy class';
    }

    /**
     * The generated file specification.
     */
    protected function specification(): string
    {
        return Policy::class;
    }
}
