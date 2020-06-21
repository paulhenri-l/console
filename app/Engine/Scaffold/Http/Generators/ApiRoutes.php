<?php

namespace PHLConsole\Engine\Scaffold\Http\Generators;

use PHLConsole\Engine\Engine;
use PaulhenriL\Generator\GeneratorSpecification;

class ApiRoutes implements GeneratorSpecification
{
    /**
     * The EngineInfo instance.
     *
     * @var Engine
     */
    protected $engine;

    /**
     * ControllerSpec constructor.
     */
    public function __construct(Engine $engine)
    {
        $this->engine = $engine;
    }

    /**
     * The template to use for generation.
     */
    public function getTemplate(): string
    {
        return file_get_contents(__DIR__ . '/stubs/routes/api.stub');
    }

    /**
     * Return the target path for the generated file.
     */
    public function getTargetPath(): string
    {
        return $this->engine->getEnginePath(
            "routes/api.php"
        );
    }

    /**
     * Return the replacements
     */
    public function getReplacements(): array
    {
        return [
            //
        ];
    }

    /**
     * Return template processors.
     */
    public function getProcessors(): array
    {
        return [];
    }
}
