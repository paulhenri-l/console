<?php

namespace PHLConsole\Engine\NewEngine\Tasks;

use PHLConsole\Engine\Engine;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class ComposerUpdate implements TaskInterface
{
    /**
     * Install composer dependencies in the engine.
     */
    public function run(Command $command, Engine $engine): void
    {
        $process = Process::fromShellCommandline(
            "composer update", $engine->getEnginePath(), null, null, null
        );

        if (getenv('DISABLE_TTY') !== '1') {
            $process->setTty(Process::isTtySupported());
        }

        $process->run(function ($type, $line) use ($command) {
            $command->getOutput()->write($line);
        });
    }
}
