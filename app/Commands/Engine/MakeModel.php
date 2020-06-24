<?php

namespace PHLConsole\Commands\Engine;

use PHLConsole\Commands\GeneratorCommand;
use PHLConsole\Engine\Make\Generators\Model;

class MakeModel extends GeneratorCommand
{
    /**
     * The command signature.
     */
    protected function signature(): string
    {
        return 'make:model';
    }

    /**
     * The command description.
     */
    protected function description(): string
    {
        return 'Create a new Eloquent model class';
    }

    /**
     * The generated file specification.
     */
    protected function specification(): string
    {
        return Model::class;
    }
}
