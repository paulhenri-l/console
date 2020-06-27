<?php

namespace PHLConsole\Commands\Engine;

use PHLConsole\Commands\GeneratorCommand;
use PHLConsole\Engine\Make\Generators\Rule;

class MakeRule extends GeneratorCommand
{
    /**
     * The command signature.
     */
    protected function signature(): string
    {
        return 'make:rule';
    }

    /**
     * The command description.
     */
    protected function description(): string
    {
        return 'Create a new validation rule';
    }

    /**
     * The generated file specification.
     */
    protected function specification(): string
    {
        return Rule::class;
    }
}
