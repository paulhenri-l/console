<?php

namespace PHLConsole\Engine;

use Illuminate\Support\Str;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

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
    protected $cwd;

    /**
     * EngineInfo constructor.
     */
    public function __construct(string $rawEngineName, string $cwd)
    {
        $this->rawEngineName = $rawEngineName;
        $this->cwd = $cwd;
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
        $enginePath = Str::finish($this->cwd, DIRECTORY_SEPARATOR);
        $enginePath .= $this->getDirectoryName();

        if ($extra) {
            $enginePath .= Str::start(
                str_replace('/', DIRECTORY_SEPARATOR, $extra),
                DIRECTORY_SEPARATOR
            );
        }

        return $enginePath;
    }

    /**
     * Return the engine's directory name.
     */
    public function getDirectoryName(): string
    {
        return explode('/', $this->rawEngineName)[1];
    }
}
