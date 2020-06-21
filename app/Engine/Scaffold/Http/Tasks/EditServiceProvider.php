<?php

namespace PHLConsole\Engine\Scaffold\Http\Tasks;

use Illuminate\Console\Command;
use PHLConsole\Engine\Engine;
use PHLConsole\Engine\EngineFactory;
use PaulhenriL\Generator\Generator;

class EditServiceProvider
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
     * EditServiceProvider constructor.
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
        $this->engine->addLoadApiRoutes();
        $this->engine->addLoadWebRoutes();
        $this->engine->addLoadViews();

        $command->info('ServiceProvider updated.');
        $command->comment(" - loadApiRoutes() added");
        $command->comment(" - loadWebRoutes() added");
        $command->comment(" - loadViews() added");
    }
}
