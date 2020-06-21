<?php

namespace PHLConsole\Engine\NewEngine\Tasks;

use PHLConsole\Engine\Engine;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class CreateEngineDirectory implements TaskInterface
{
    /**
     * The Filesystem instance.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * CreateEngineDirectory constructor.
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Create the engine directory.
     */
    public function run(Command $command, Engine $engine): void
    {
        $enginePath = $engine->getEnginePath();

        if ($this->filesystem->exists($enginePath)) {
            throw new TaskException(
                "The [{$enginePath}] directory already exists"
            );
        }

        $command->info("Directory [{$engine->getDirectoryName()}] created");

        $this->filesystem->makeDirectory($enginePath);
    }
}
