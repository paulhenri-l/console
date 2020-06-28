<?php

namespace PHLConsole\Commands\Engine;

use PHLConsole\Commands\GeneratorCommand;
use PHLConsole\Engine\Make\Generators\Test;

class MakeTest extends GeneratorCommand
{
    /**
     * The command signature.
     */
    protected function signature(): string
    {
        return 'make:test';
    }

    /**
     * The command description.
     */
    protected function description(): string
    {
        return 'Create a new test class';
    }

    /**
     * The generated file specification.
     */
    protected function specification(): string
    {
        return Test::class;
    }
}
