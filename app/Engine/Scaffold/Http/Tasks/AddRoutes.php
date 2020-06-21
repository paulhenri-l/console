<?php

namespace PHLConsole\Engine\Scaffold\Http\Tasks;

use Illuminate\Console\Command;
use PHLConsole\Engine\Engine;
use PHLConsole\Engine\EngineFactory;
use PHLConsole\Engine\Scaffold\Http\Generators\ApiRoutes;
use PHLConsole\Engine\Scaffold\Http\Generators\WebRoutes;
use PHLConsole\Generator\Generator;

class AddRoutes
{
    /**
     * The Engine instance.
     *
     * @var Engine
     */
    protected $engine;

    /**
     * The Generator instance.
     *
     * @var Generator
     */
    protected $generator;

    /**
     * AddRoutes constructor.
     */
    public function __construct(EngineFactory $engineFactory, Generator $generator)
    {
        $this->engine = $engineFactory->buildFromCwd();
        $this->generator = $generator;
    }

    /**
     * Run the task.
     */
    public function run(Command $command)
    {
        // Check if files already exists
        $webRoutes = new WebRoutes(
            $this->engine
        );

        $apiRoutes = new ApiRoutes(
            $this->engine
        );

        $webFile = str_replace(
            $this->engine->getEnginePath() . '/',
            '',
            $this->generator->generate($webRoutes)
        );

        $apiFile = str_replace(
            $this->engine->getEnginePath() . '/',
            '',
            $this->generator->generate($apiRoutes)
        );

        $command->info('Route files generated.');
        $command->comment(" - $webFile");
        $command->comment(" - $apiFile");
    }
}
