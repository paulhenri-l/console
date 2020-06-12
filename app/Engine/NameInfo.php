<?php

namespace App\Engine;

use Illuminate\Support\Str;

class NameInfo
{
    /**
     * The raw engine name.
     *
     * @var string
     */
    protected $engineName;

    /**
     * NameInfo constructor.
     */
    public function __construct(string $engineName)
    {
        $this->engineName = $engineName;
    }

    /**
     * Return the engine's composer package name.
     */
    public function getComposerPackageName(): string
    {
        return $this->engineName;
    }

    /**
     * Return the engine's vendor name.
     */
    public function getVendorName(): string
    {
        return Str::studly(explode('/', $this->engineName)[0]);
    }

    /**
     * Return the engine's package name.
     */
    public function getPackageName(): string
    {
        return Str::studly(explode('/', $this->engineName)[1]);
    }

    /**
     * Return the engine's directory name.
     */
    public function getDirectoryName(): string
    {
        return explode('/', $this->engineName)[1];
    }
}
