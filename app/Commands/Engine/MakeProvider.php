<?php

namespace PHLConsole\Commands\Engine;

use PHLConsole\Commands\GeneratorCommand;
use PHLConsole\Engine\Make\Generators\Provider;

class MakeProvider extends GeneratorCommand
{
    /**
     * The command signature.
     */
    protected function signature(): string
    {
        return 'make:provider';
    }

    /**
     * The command description.
     */
    protected function description(): string
    {
        return 'Create a new service provider class';
    }

    /**
     * The generated file specification.
     */
    protected function specification(): string
    {
        return Provider::class;
    }
}
