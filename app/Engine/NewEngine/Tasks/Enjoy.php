<?php

namespace PHLConsole\Engine\NewEngine\Tasks;

use Illuminate\Console\Command;

class Enjoy
{
    /**
     * Tell the user how much he'll enjoy is new engine!
     */
    public function __invoke(Command $command)
    {
        $command->info('🎉 Your engine is ready!');
    }
}
