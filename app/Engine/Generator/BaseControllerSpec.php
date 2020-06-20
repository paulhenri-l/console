<?php

namespace PHLConsole\Engine\Generator;

use PHLConsole\Engine\EngineInfo;
use PHLConsole\Generator\GeneratorSpecification;

class BaseControllerSpec implements GeneratorSpecification
{
    /**
     * The EngineInfo instance.
     *
     * @var EngineInfo
     */
    protected $engineInfo;

    /**
     * ControllerSpec constructor.
     */
    public function __construct(EngineInfo $engineInfo)
    {
        $this->engineInfo = $engineInfo;
    }

    /**
     * The template to use for generation.
     */
    public function getTemplate(): string
    {
        return file_get_contents(__DIR__ . '/stubs/base_controller.stub');
    }

    /**
     * Return the target path for the generated file.
     */
    public function getTargetPath(): string
    {
        return $this->engineInfo->getEnginePath(
            "src/Http/Controllers/Controller.php"
        );
    }

    /**
     * Return the replacements
     */
    public function getReplacements(): array
    {
        return [
            'rootNamespace' => $this->engineInfo->getEngineNamespace(),
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
