<?php

namespace PHLConsole\Commands\Engine;

use Illuminate\Support\Str;
use PHLConsole\Engine\Engine;
use PHLConsole\Engine\NewEngine\Tasks\CloneBaseEngine;
use PHLConsole\Engine\NewEngine\Tasks\ComposerUpdate;
use PHLConsole\Engine\NewEngine\Tasks\CreateEngineDirectory;
use PHLConsole\Engine\NewEngine\Tasks\Enjoy;
use PHLConsole\Engine\NewEngine\Tasks\RenameEngine;
use LaravelZero\Framework\Commands\Command;
use PaulhenriL\LaravelTaskRunner\CanRunTasks;
use PHLConsole\Engine\NewEngine\Tasks\TaskException;

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

        $engine = $this->makeNewEngine($rawName);

        $finished = $this->runTasks([
            new CreateEngineDirectory($engine),
            new CloneBaseEngine($engine),
            new RenameEngine($engine),
            new ComposerUpdate($engine),
            new Enjoy(),
        ]);

        if (!$finished) {
            return 1;
        }

        $this->line('');

        return 0;
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
    protected function makeNewEngine(string $rawEngineName): Engine
    {
        $engineName = explode('/', $rawEngineName)[1];

        return new Engine(
            $rawEngineName,
            getcwd() . Str::start($engineName, '/')
        );
    }
}
