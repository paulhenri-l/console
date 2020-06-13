<?php

namespace PHLConsole\Engine\Tasks;

use PHLConsole\Engine\EngineInfo;
use Illuminate\Console\Command;

interface TaskInterface
{
    /**
     * Run the task.
     * @param Command $command
     */
    public function run(Command $command, EngineInfo $engineInfo): void;
}
