<?php

namespace PHLConsole\Commands\Engine;

use PHLConsole\Commands\GeneratorCommand;
use PHLConsole\Engine\Make\Generators\Request;

class MakeRequest extends GeneratorCommand
{
    /**
     * The command signature.
     */
    protected function signature(): string
    {
        return 'make:request';
    }

    /**
     * The command description.
     */
    protected function description(): string
    {
        return 'Create a new form request class';
    }

    /**
     * The generated file specification.
     */
    protected function specification(): string
    {
        return Request::class;
    }
}
