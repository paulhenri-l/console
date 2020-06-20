<?php

namespace PHLConsole\Commands\Engine;

use LaravelZero\Framework\Commands\Command;
use PHLConsole\Engine\EngineInfo;
use PHLConsole\Engine\Generator\BaseControllerSpec;
use PHLConsole\Engine\Generator\ControllerSpec;
use PHLConsole\Generator\Generator;
use PHLConsole\Generator\Keywords;

class MakeController extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'make:controller {name} {--force}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Generate a new controller';

    /**
     * The Generator instance.
     *
     * @var Generator
     */
    protected $generator;

    /**
     * MakeController constructor.
     */
    public function __construct(Generator $generator)
    {
        parent::__construct();
        $this->generator = $generator;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $engineInfo = $this->makeNewEngineInfo();

        if (Keywords::isReserved($name)) {
            $this->error("The name '{$name}' is reserved by PHP.");
            return 0;
        }

        $controllerSpec = new ControllerSpec(
            $engineInfo, $this->argument('name')
        );

        $baseController = new BaseControllerSpec(
            $engineInfo
        );

        if (!file_exists($baseController->getTargetPath())) {
            $this->generator->generate($baseController);
        }

        if (!$this->option('force') && file_exists($controllerSpec->getTargetPath())) {
            $this->error("The '{$name}' controller already exists.");
            return 0;
        }

        $this->generator->generate($controllerSpec);

        $this->info('Controller generated.');
    }

    /**
     * Make a new EngineInfo instance for the engine that we want to create.
     */
    protected function makeNewEngineInfo(): EngineInfo
    {
        $engineName = json_decode(
            file_get_contents(getcwd() . '/composer.json'), true
        )['name'];

        return new EngineInfo($engineName, getcwd());
    }
}
