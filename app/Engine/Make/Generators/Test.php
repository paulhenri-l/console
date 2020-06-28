<?php

namespace PHLConsole\Engine\Make\Generators;

class Test extends EngineClassGenerator
{
    /**
     * Return the path to the class template.
     */
    protected function getTemplatePath(): string
    {
        return __DIR__ . '/stubs/test.stub';
    }

    /**
     * Return the target path for the generated file.
     */
    public function getTargetPath(): string
    {
        $namespace = $this->getTargetNamespace();
        $namespace = str_replace('Tests\\', '', $namespace);
        $targetPath = str_replace('\\', '/', $namespace);

        return $this->engine->getEnginePath(
            "tests/{$targetPath}/{$this->name}.php"
        );
    }

    /**
     * Return the namespace for the new class.
     */
    function getTargetNamespace(): string
    {
        return 'Tests\Feature';
    }
}
