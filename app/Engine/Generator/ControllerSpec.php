<?php

namespace PHLConsole\Engine\Generator;

use PHLConsole\Engine\EngineInfo;
use PHLConsole\Generator\GeneratorSpecification;
use PHLConsole\Generator\SortUsesProcessor;

class ControllerSpec implements GeneratorSpecification
{
    /**
     * The EngineInfo instance.
     *
     * @var EngineInfo
     */
    protected $engineInfo;

    /**
     * The Controller name.
     *
     * @var string
     */
    protected $name;

    /**
     * ControllerSpec constructor.
     */
    public function __construct(EngineInfo $engineInfo, string $name)
    {
        $this->name = str_replace('\\', '/', $name);
        $this->engineInfo = $engineInfo;
    }

    /**
     * The template to use for generation.
     */
    public function getTemplate(): string
    {
        return file_get_contents(__DIR__ . '/stubs/controller.stub');
    }

    /**
     * Return the target path for the generated file.
     */
    public function getTargetPath(): string
    {
        return $this->engineInfo->getEnginePath(
            "src/Http/Controllers/{$this->name}.php"
        );
    }

    /**
     * Return the replacements
     */
    public function getReplacements(): array
    {
        return [
            'namespace' => $this->getControllerNamespace(),
            'rootNamespace' => $this->engineInfo->getEngineNamespace(),
            'class' => $this->getControllerName()
        ];
    }

    /**
     * Return template processors.
     */
    public function getProcessors(): array
    {
        return [
            [$this, 'removeUnnecessaryUse'],
            new SortUsesProcessor()
        ];
    }

    /**
     * Remove unnecessary controller use.
     */
    public function removeUnnecessaryUse(string $template)
    {
        $controllerNamespace = $this->engineInfo->getEngineNamespace(
            'Http\Controllers'
        );

        return str_replace(
            "use {$controllerNamespace}\Controller;\n",
            '',
            $template
        );
    }

    /**
     * Return the controller name.
     */
    protected function getControllerName(): string
    {
        $parts = explode('/', $this->name);

        return array_pop($parts);
    }

    /**
     * Return the controller's namespace.
     */
    protected function getControllerNamespace(): string
    {
        $parts = explode('/', $this->name);

        // Remove controller name.
        array_pop($parts);

        $relativeNamespace = count($parts)
            ? '\\' . implode('\\', $parts)
            : '';

        return $this->engineInfo->getEngineNamespace(
            "Http\Controllers{$relativeNamespace}"
        );
    }
}
