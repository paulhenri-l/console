<?php

namespace PHLConsole\Commands\Engine;

use PHLConsole\Commands\GeneratorCommand;
use PHLConsole\Engine\Make\Generators\Job;

class MakeJob extends GeneratorCommand
{
    /**
     * The command signature.
     */
    protected function signature(): string
    {
        return 'make:job';
    }

    /**
     * The command description.
     */
    protected function description(): string
    {
        return 'Create a new job class';
    }

    /**
     * The generated file specification.
     */
    protected function specification(): string
    {
        return Job::class;
    }
}
