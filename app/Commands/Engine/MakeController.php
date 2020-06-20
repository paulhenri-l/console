<?php

namespace PHLConsole\Commands\Engine;

use LaravelZero\Framework\Commands\Command;
use PHLConsole\Engine\EngineInfo;
use PHLConsole\Engine\Generator\ControllerSpec;
use PHLConsole\Generator\Generator;

class MakeController extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'make:controller {name}';

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
        // Check for reserved keyword.
        // Check if file exists.

        $spec = new ControllerSpec(
            $this->makeNewEngineInfo(),
            $this->argument('name')
        );

        $this->generator->generate($spec);
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
