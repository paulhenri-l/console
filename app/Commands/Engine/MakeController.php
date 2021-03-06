<?php

namespace PHLConsole\Commands\Engine;

use PHLConsole\Commands\GeneratorCommand;
use PHLConsole\Engine\Make\Generators\Controller;

class MakeController extends GeneratorCommand
{
    /**
     * The command signature.
     */
    protected function signature(): string
    {
        return 'make:controller';
    }

    /**
     * The command description.
     */
    protected function description(): string
    {
        return 'Create a new controller class';
    }

    /**
     * The generated file specification.
     */
    protected function specification(): string
    {
        return Controller::class;
    }
}
