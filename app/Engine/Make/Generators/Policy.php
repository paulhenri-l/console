<?php

namespace PHLConsole\Engine\Make\Generators;

class Policy extends EngineClassGenerator
{
    /**
     * Return the path to the class template.
     */
    protected function getTemplatePath(): string
    {
        return __DIR__ . '/stubs/policy.stub';
    }

    /**
     * Return the namespace for the new class.
     */
    function getTargetNamespace(): string
    {
        return 'Policies';
    }
}
