<?php

namespace PHLConsole\Engine\Scaffold\Http\Generators;

use PaulhenriL\Generator\GeneratorSpecification;
use PHLConsole\Engine\Engine;

class WelcomeView implements GeneratorSpecification
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
        return file_get_contents(
            __DIR__ . '/stubs/resources/views/welcome.stub'
        );
    }

    /**
     * Return the target path for the generated file.
     */
    public function getTargetPath(): string
    {
        return $this->engine->getEnginePath(
            "resources/views/welcome.php"
        );
    }

    /**
     * Return the replacements
     */
    public function getReplacements(): array
    {
        return [
            'engineName' => $this->engine->getEngineName()
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
