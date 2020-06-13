<?php

namespace PHLConsole\Engine\Tasks;

use PHLConsole\Engine\EngineInfo;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class ComposerInstall implements TaskInterface
{
    /**
     * Install composer dependencies in the engine.
     */
    public function run(Command $command, EngineInfo $engineInfo): void
    {
        $process = Process::fromShellCommandline(
            "composer install", $engineInfo->getEnginePath(), null, null, null
        );

        if (getenv('DISABLE_TTY') !== '1') {
            $process->setTty(Process::isTtySupported());
        }

        $process->run(function ($type, $line) use ($command) {
            $command->getOutput()->write($line);
        });
    }
}
