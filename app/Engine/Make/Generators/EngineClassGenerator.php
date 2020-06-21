<?php

namespace PHLConsole\Engine\Make\Generators;

use PaulhenriL\Generator\GeneratorSpecification;
use PaulhenriL\Generator\SortUsesProcessor;
use PHLConsole\Engine\Engine;

abstract class EngineClassGenerator implements GeneratorSpecification
{
    /**
     * The EngineInfo instance.
     *
     * @var Engine
     */
    protected $engine;

    /**
     * The cast name.
     *
     * @var string
     */
    protected $name;

    /**
     * Cast constructor.
     */
    public function __construct(Engine $engine, string $name)
    {
        $this->name = str_replace('\\', '/', $name);
        $this->engine = $engine;
    }

    /**
     * The template to use for generation.
     */
    public function getTemplate(): string
    {
        return file_get_contents($this->getTemplatePath());
    }

    /**
     * Return the target path for the generated file.
     */
    public function getTargetPath(): string
    {
        $namespace = $this->getTargetNamespace();
        $targetPath = str_replace('\\', '/', $namespace);

        return $this->engine->getEnginePath(
             "src/{$targetPath}/{$this->name}.php"
        );
    }

    /**
     * Return the replacements
     */
    public function getReplacements(): array
    {
        return array_merge([
            'namespace' => $this->getGeneratedClassNamespace(),
            'rootNamespace' => $this->engine->getEngineNamespace(),
            'class' => $this->getClassname(),
        ], $this->getExtraReplacements());
    }

    /**
     * Return template processors.
     */
    public function getProcessors(): array
    {
        return array_merge([
            new SortUsesProcessor(),
        ], $this->getExtraProcessors());
    }

    /**
     * Return the generated class' name.
     */
    protected function getClassname(): string
    {
        $parts = explode('/', $this->name);

        return array_pop($parts);
    }

    /**
     * Return the generated class' namespace.
     */
    protected function getGeneratedClassNamespace(): string
    {
        $parts = explode('/', $this->name);

        // Remove classname.
        array_pop($parts);

        $relativeNamespace = count($parts)
            ? '\\' . implode('\\', $parts)
            : '';

        return $this->engine->getEngineNamespace(
            "{$this->getTargetNamespace()}{$relativeNamespace}"
        );
    }

    /**
     * Return the path to the class template.
     */
    abstract protected function getTemplatePath(): string;

    /**
     * Return the namespace for the new class.
     */
    abstract function getTargetNamespace(): string;

    /**
     * Add extra replacement variables.
     */
    protected function getExtraReplacements(): array
    {
        return [];
    }

    /**
     * Add extra processors.
     */
    protected function getExtraProcessors(): array
    {
        return [];
    }
}
