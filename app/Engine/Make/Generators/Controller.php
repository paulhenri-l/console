<?php

namespace PHLConsole\Engine\Make\Generators;

class Controller extends EngineClassGenerator
{
    /**
     * Return the path to the class template.
     */
    protected function getTemplatePath(): string
    {
        return __DIR__ . '/stubs/controller.stub';
    }

    /**
     * Return the namespace for the new class.
     */
    function getTargetNamespace(): string
    {
        return 'Http\Controllers';
    }

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
        return [
            [$this, 'removeUnnecessaryUse'],
            [$this, 'removeBaseController']
        ];
    }

    /**
     * Remove unnecessary controller use.
     */
    public function removeUnnecessaryUse(string $template)
    {
        $controllerNamespace = $this->getGeneratedClassNamespace();

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
}
