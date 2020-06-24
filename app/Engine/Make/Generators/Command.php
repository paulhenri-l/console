<?php

namespace PHLConsole\Engine\Make\Generators;

use Illuminate\Support\Str;

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
        $commandName = str_replace('/', ':', $this->name);
        $commandNamespace = Str::kebab($this->engine->getEngineName());

        return [
            'command' => strtolower(
                "{$commandNamespace}:{$commandName}"
            )
        ];
    }
}
