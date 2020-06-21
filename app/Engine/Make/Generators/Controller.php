<?php

namespace PHLConsole\Engine\Make\Generators;

use PHLConsole\Engine\Engine;
use PHLConsole\Generator\GeneratorSpecification;
use PHLConsole\Generator\SortUsesProcessor;

class Controller implements GeneratorSpecification
{
    /**
     * The EngineInfo instance.
     *
     * @var Engine
     */
    protected $engine;

    /**
     * The Controller name.
     *
     * @var string
     */
    protected $name;

    /**
     * ControllerSpec constructor.
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
        return file_get_contents(
            __DIR__ . '/stubs/controller.stub'
        );
    }

    /**
     * Return the target path for the generated file.
     */
    public function getTargetPath(): string
    {
        return $this->engine->getEnginePath(
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
            'rootNamespace' => $this->engine->getEngineNamespace(),
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
            new SortUsesProcessor(),
            [$this, 'removeBaseController']
        ];
    }

    /**
     * Remove unnecessary controller use.
     */
    public function removeUnnecessaryUse(string $template)
    {
        $controllerNamespace = $this->getControllerNamespace();

        return str_replace(
            "use {$controllerNamespace}\Controller;\n",
            '',
            $template
        );
    }

    /**
     * Remove the extend statement if base controller does not exists.
     */
    public function removeBaseController(string $template)
    {
        $baseControllerPath = $this->engine->getEnginePath(
            'src/Http/Controllers/Controller.php'
        );

        $baseControllerNamespace = $this->engine->getEngineNamespace(
            'Http\Controllers\Controller'
        );

        if (!file_exists($baseControllerPath)) {
            $template = str_replace(
                ' extends Controller', '', $template
            );

            $template = str_replace(
                "use {$baseControllerNamespace};\n", '', $template
            );
        }

        return $template;
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

        return $this->engine->getEngineNamespace(
            "Http\Controllers{$relativeNamespace}"
        );
    }
}
