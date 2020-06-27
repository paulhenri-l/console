<?php

namespace PHLConsole\Commands\Engine;

use PHLConsole\Commands\GeneratorCommand;
use PHLConsole\Engine\Make\Generators\Resource;

class MakeResource extends GeneratorCommand
{
    /**
     * The command signature.
     */
    protected function signature(): string
    {
        return 'make:resource';
    }

    /**
     * The command description.
     */
    protected function description(): string
    {
        return 'Create a new resource';
    }

    /**
     * The generated file specification.
     */
    protected function specification(): string
    {
        return Resource::class;
    }
}
