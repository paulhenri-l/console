<?php

namespace PHLConsole\Engine\Tasks;

use PHLConsole\Engine\EngineInfo;
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
    public function run(Command $command, EngineInfo $engineInfo): void
    {
        $enginePath = $engineInfo->getEnginePath();

        if (is_dir($enginePath) || is_file($enginePath)) {
            $command->error(
                "The [{$enginePath}] directory already exists" . PHP_EOL
            );

            exit(1);
        }

        $this->filesystem->makeDirectory($enginePath);
    }
}
