<?php

namespace PHLConsole\Engine\NewEngine\Tasks;

use PHLConsole\Engine\Engine;
use Illuminate\Console\Command;

interface TaskInterface
{
    /**
     * Run the task.
     * @param Command $command
     */
    public function run(Command $command, Engine $engine): void;
}
