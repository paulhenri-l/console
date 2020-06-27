<?php

namespace PHLConsole\Engine\Make\Generators;

use Illuminate\Support\Str;
use PaulhenriL\Generator\GeneratorSpecification;
use PHLConsole\Engine\Engine;

class Migration implements GeneratorSpecification
{
    /**
     * The EngineInfo instance.
     *
     * @var Engine
     */
    protected $engine;

    /**
     * The file name.
     *
     * @var string
     */
    protected $name;

    /**
     * EngineFileGenerator constructor.
     */
    public function __construct(Engine $engine, string $name)
    {
        $this->name = $name;
        $this->engine = $engine;
    }

    /**
     * The template to use for generation.
     */
    public function getTemplate(): string
    {
        return file_get_contents(
            __DIR__ . '/stubs/migration.stub'
        );
    }

    /**
     * Return the target path for the generated file.
     */
    function getTargetPath(): string
    {
        $migrationPath = '/database/migrations/';
        $migrationPath .= now()->format('Y_m_d_His');
        $migrationPath .= '_';
        $migrationPath .= strtolower($this->name);
        $migrationPath .= '.php';

        return $this->engine->getEnginePath(
            $migrationPath
        );
    }

    /**
     * Return the replacements
     */
    function getReplacements(): array
    {
        return [
            'class' => Str::studly($this->name)
        ];
    }

    /**
     * Return template processors.
     */
    function getProcessors(): array
    {
        return [];
    }
}
