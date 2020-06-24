<?php

namespace PHLConsole\Engine\Make\Generators;

class Command extends EngineClassGenerator
{
    /**
     * Return the path to the class template.
     */
    protected function getTemplatePath(): string
    {
        return __DIR__ . '/stubs/command.stub';
    }

    /**
     * Return the namespace for the new class.
     */
    function getTargetNamespace(): string
    {
        return 'Console\Commands';
    }

    /**
     * Add extra replacement variables.
     */
    protected function getExtraReplacements(): array
    {
        return [
            'command' => strtolower(
                str_replace('/', ':', $this->name)
            )
        ];
    }
}
