<?php

namespace PHLConsole\Commands\Engine;

use PHLConsole\Engine\EngineInfo;
use PHLConsole\Engine\Tasks\CloneBaseEngine;
use PHLConsole\Engine\Tasks\ComposerInstall;
use PHLConsole\Engine\Tasks\CreateEngineDirectory;
use PHLConsole\Engine\Tasks\Enjoy;
use PHLConsole\Engine\Tasks\RenameEngine;
use LaravelZero\Framework\Commands\Command;
use PaulhenriL\LaravelTaskRunner\CanRunTasks;

class NewEngine extends Command
{
    use CanRunTasks;

    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'new:engine {name}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Create a new engine of the given name the name must be specified in the vendor/package-name format.';

    /**
     * The new engine tasks..
     *
     * @var array
     */
    protected $tasks;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧙‍ Generating your engine, sit tight...');
        $this->line('');

        $engineInfo = new EngineInfo($this->argument('name'), getcwd());

        $this->runTasks([
            CreateEngineDirectory::class,
            CloneBaseEngine::class,
            RenameEngine::class,
            ComposerInstall::class,
            Enjoy::class
        ], $this, $engineInfo);

        $this->line('');
    }
}
