<?php

namespace PHLConsole\Engine\NewEngine\Tasks;

use Illuminate\Filesystem\Filesystem;
use PHLConsole\Engine\Engine;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class CloneBaseEngine implements TaskInterface
{
    /**
     * The Filesystem instance.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * CloneBaseEngine constructor.
     */
    public function __construct(Filesystem $filesystem) {
        $this->filesystem = $filesystem;
    }

    /**
     * Clone the base engine inside the engine directory.
     */
    public function run(Command $command, Engine $engine): void
    {
        $this->cloneRepo($command, $engine);
        $this->filesystem->deleteDirectory($engine->getEnginePath('.git'));
        $this->filesystem->delete($engine->getEnginePath('LICENSE'));
    }

    /**
     * Clone the base repo.
     */
    protected function cloneRepo(Command $command, Engine $engine)
    {
        $repo = 'https://github.com/paulhenri-l/laravel-engine.git';

        $process = Process::fromShellCommandline(
            "git clone {$repo} {$engine->getEnginePath()}", null, null, null
        );

        if (getenv('DISABLE_TTY') !== '1') {
            $process->setTty(Process::isTtySupported());
        }

        $process->run(function ($type, $line) use ($command) {
            $command->getOutput()->write($line);
        });
    }
}
