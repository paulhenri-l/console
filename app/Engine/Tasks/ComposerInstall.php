<?php

namespace PHLConsole\Engine\Tasks;

use PHLConsole\Engine\EngineInfo;
use PHLConsole\Services\CommandRunner;
use Illuminate\Console\Command;

class ComposerInstall implements TaskInterface
{
    /**
     * The CommandRunner instance.
     *
     * @var CommandRunner
     */
    protected $commandRunner;

    /**
     * ComposerInstall constructor.
     */
    public function __construct(CommandRunner $commandRunner)
    {
        $this->commandRunner = $commandRunner;
    }

    /**
     * Install composer dependencies in the engine.
     */
    public function run(Command $command, EngineInfo $engineInfo): void
    {
        $this->commandRunner->run(
            'composer install',
            $engineInfo->getEnginePath(),
            function ($line) use ($command) {
                $command->getOutput()->writeln($line);
            }
        );
    }
}
