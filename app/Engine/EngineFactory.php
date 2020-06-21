<?php

namespace PHLConsole\Engine;

use Illuminate\Filesystem\Filesystem;

class EngineFactory
{
    /**
     * The Filesystem instance.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * EngineFactory constructor.
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Create a new engine instance for the engine we are currently in.
     */
    public function buildFromCwd()
    {
        $composerJson = file_get_contents(getcwd() . '/composer.json');

        if (!$composerJson) {
            throw new NotInAnEngineException();
        }

        $engineName = json_decode(
            $composerJson, true
        )['name'];

        return new Engine($engineName, getcwd(), $this->filesystem);
    }
}
