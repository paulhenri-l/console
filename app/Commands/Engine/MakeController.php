<?php

namespace PHLConsole\Commands\Engine;

use PaulhenriL\Generator\GeneratorSpecification;
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
        return 'Generate a new controller';
    }

    /**
     * The generated file specification.
     */
    protected function specification(): GeneratorSpecification
    {
        $engine = $this->engineFactory->buildFromCwd();

        return new Controller(
            $engine, $this->inputName()
        );
    }
}
