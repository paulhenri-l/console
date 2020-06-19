<?php

namespace PHLConsole\Engine;

use Illuminate\Support\Str;

class EngineInfo
{
    /**
     * The string instance.
     *
     * @var string
     */
    protected $rawEngineName;

    /**
     * The string instance.
     *
     * @var string
     */
    protected $engineDirectory;

    /**
     * EngineInfo constructor.
     */
    public function __construct(string $rawEngineName, string $engineDirectory)
    {
        $this->rawEngineName = $rawEngineName;
        $this->engineDirectory = $engineDirectory;
    }

    /**
     * Return the engine's composer package name.
     */
    public function getPackageName(): string
    {
        return $this->rawEngineName;
    }

    /**
     * Return the engine's vendor name.
     */
    public function getVendorName(): string
    {
        return Str::studly(explode('/', $this->rawEngineName)[0]);
    }

    /**
     * Return the engine's name.
     */
    public function getEngineName(): string
    {
        return Str::studly(explode('/', $this->rawEngineName)[1]);
    }

    /**
     * Return the engine namespace.
     */
    public function getEngineNamespace(string $extra = null): string
    {
        $extra = $extra
            ? Str::start($extra, '\\')
            : '';

        return "{$this->getVendorName()}\\{$this->getEngineName()}" . $extra;
    }

    /**
     * Return the engine's test database name.
     */
    public function getEngineTestDatabaseName(): string
    {
        return Str::snake($this->getEngineName()) . '_tests';
    }

    /**
     * Return the engine's path.
     */
    public function getEnginePath(string $extra = null): string
    {
        $extra = $extra
            ? Str::start($extra, DIRECTORY_SEPARATOR)
            : '';

        $extra = str_replace('/', DIRECTORY_SEPARATOR, $extra);

        return $this->engineDirectory . $extra;
    }

    /**
     * Return the engine's directory name.
     */
    public function getDirectoryName(): string
    {
        return explode('/', $this->rawEngineName)[1];
    }
}
