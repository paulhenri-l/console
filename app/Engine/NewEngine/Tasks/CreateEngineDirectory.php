<?php

namespace PHLConsole\Engine\NewEngine\Tasks;

use PHLConsole\Engine\Engine;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class CreateEngineDirectory
{
    /**
     * The Engine instance.
     *
     * @var Engine
     */
    protected $engine;

    /**
     * The Filesystem instance.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * CreateEngineDirectory constructor.
     */
    public function __construct(Engine $engine, Filesystem $filesystem = null)
    {
        $this->engine = $engine;
        $this->filesystem = $filesystem ?? new Filesystem();
    }

    /**
     * Create the engine directory.
     */
    public function __invoke(Command $command)
    {
        $enginePath = $this->engine->getEnginePath();

        if ($this->filesystem->exists($enginePath)) {
            $command->error("The [{$enginePath}] directory already exists");
            return false;
        }

        $command->info(
            "Directory [{$this->engine->getDirectoryName()}] created"
        );

        $this->filesystem->makeDirectory($enginePath);
    }
}
