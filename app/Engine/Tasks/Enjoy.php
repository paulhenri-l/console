<?php

namespace PHLConsole\Engine\Tasks;

use Illuminate\Console\Command;
use PHLConsole\Engine\EngineInfo;

class Enjoy implements TaskInterface
{
    /**
     * Tell the user how much he'll enjoy is new engine!
     */
    public function run(Command $command, EngineInfo $engineInfo): void
    {
        $command->info('🎉 Your engine is ready!');
    }
}
