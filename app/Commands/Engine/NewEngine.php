<?php

namespace PHLConsole\Commands\Engine;

use Illuminate\Support\Str;
use PHLConsole\Engine\EngineInfo;
use PHLConsole\Engine\EngineInfoFactory;
use PHLConsole\Engine\Tasks\CloneBaseEngine;
use PHLConsole\Engine\Tasks\ComposerUpdate;
use PHLConsole\Engine\Tasks\CreateEngineDirectory;
use PHLConsole\Engine\Tasks\Enjoy;
use PHLConsole\Engine\Tasks\RenameEngine;
use LaravelZero\Framework\Commands\Command;
use PaulhenriL\LaravelTaskRunner\CanRunTasks;
use PHLConsole\Engine\Tasks\TaskException;

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
    protected $description = 'Create a new engine of the given name. The name must be specified in the vendor/package-name format.';

    /**
     * The new engine tasks..
     *
     * @var array
     */
    protected $tasks = [
        CreateEngineDirectory::class,
        CloneBaseEngine::class,
        RenameEngine::class,
        ComposerUpdate::class,
        Enjoy::class
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $rawName = $this->argument('name');

        if (!$this->validateName($rawName)) {
            $this->error("Your engine name must be in the format 'vendor-name/engine-name'");
            return 1;
        }

        $this->info('🧙‍ Generating your engine, sit tight...');
        $this->line('');


        try {
            $this->runTasks(
                $this->tasks,
                $this,
                $this->makeNewEngineInfo($rawName)
            );
        } catch (TaskException $taskException) {
            $this->error($taskException->getMessage());
            $this->line('');
            return 1;
        }

        $this->line('');
    }

    /**
     * Validate that user provided name.
     */
    protected function validateName(string $name): bool
    {
        return preg_match('/.+\/.+$/', $name);
    }

    /**
     * Make a new EngineInfo instance for the engine that we want to create.
     */
    protected function makeNewEngineInfo(string $rawEngineName): EngineInfo
    {
        $engineName = explode('/', $rawEngineName)[1];

        return new EngineInfo(
            $rawEngineName,
            getcwd() . Str::start($engineName, '/')
        );
    }
}
