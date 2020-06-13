<?php

namespace PHLConsole\Engine\Tasks;

use PHLConsole\Engine\EngineInfo;
use PHLConsole\Services\CommandRunner;
use Illuminate\Console\Command;

class CloneBaseEngine implements TaskInterface
{
    /**
     * The CommandRunner instance.
     *
     * @var CommandRunner
     */
    protected $commandRunner;

    public function __construct(CommandRunner $commandRunner)
    {

        $this->commandRunner = $commandRunner;
    }

    /**
     * Clone the base engine inside the engine directory.
     */
    public function run(Command $command, EngineInfo $engineInfo): void
    {
        $repo = 'https://github.com/paulhenri-l/laravel-engine.git';
        $enginePath = $engineInfo->getEnginePath();

        $output = function ($line) use ($command) {
            $command->getOutput()->writeln($line);
        };

        $this->commandRunner->run(
            "git clone {$repo} {$enginePath}", getcwd(), $output
        );

        $this->commandRunner->run(
            "rm -rf {$enginePath}/.git", getcwd(), $output
        );
    }
}
