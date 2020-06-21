<?php

namespace PHLConsole\Engine\Scaffold\Http\Tasks;

use Illuminate\Console\Command;

class Enjoy
{
    /**
     * Run the task.
     */
    public function __invoke(Command $command)
    {
        $command->info('🎉 The http layer is ready!');
    }
}
