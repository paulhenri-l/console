<?php

namespace PHLConsole\Engine\NewEngine\Tasks;

use PHLConsole\Engine\Engine;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class ComposerUpdate
{
    /**
     * The Engine instance.
     *
     * @var Engine
     */
    protected $engine;

    /**
     * ComposerUpdate constructor.
     */
    public function __construct(Engine $engine)
    {
        $this->engine = $engine;
    }

    /**
     * Install composer dependencies in the engine.
     */
    public function __invoke(Command $command)
    {
        $process = Process::fromShellCommandline(
            "composer update", $this->engine->getEnginePath(), null, null, null
        );

        if (getenv('DISABLE_TTY') !== '1') {
            $process->setTty(Process::isTtySupported());
        }

        $process->run(function ($type, $line) use ($command) {
            $command->getOutput()->write($line);
        });
    }
}
