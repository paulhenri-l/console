<?php

namespace PHLConsole\Engine\NewEngine\Tasks;

use Illuminate\Console\Command;
use PHLConsole\Engine\Engine;

class Enjoy implements TaskInterface
{
    /**
     * Tell the user how much he'll enjoy is new engine!
     */
    public function run(Command $command, Engine $engine): void
    {
        $command->info('🎉 Your engine is ready!');
    }
}
