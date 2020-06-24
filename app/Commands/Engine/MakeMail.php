<?php

namespace PHLConsole\Commands\Engine;

use PHLConsole\Commands\GeneratorCommand;
use PHLConsole\Engine\Make\Generators\Job;
use PHLConsole\Engine\Make\Generators\Mail;

class MakeMail extends GeneratorCommand
{
    /**
     * The command signature.
     */
    protected function signature(): string
    {
        return 'make:mail';
    }

    /**
     * The command description.
     */
    protected function description(): string
    {
        return 'Create a new email class';
    }

    /**
     * The generated file specification.
     */
    protected function specification(): string
    {
        return Mail::class;
    }
}
