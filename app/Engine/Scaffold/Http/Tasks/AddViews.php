<?php

namespace PHLConsole\Engine\Scaffold\Http\Tasks;

use Illuminate\Console\Command;
use PHLConsole\Engine\Engine;
use PHLConsole\Engine\EngineFactory;
use PHLConsole\Engine\Scaffold\Http\Generators\WelcomeView;
use PaulhenriL\Generator\Generator;

class AddViews
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
     * AddViews constructor.
     */
    public function __construct(EngineFactory $engineFactory, Generator $generator)
    {
        $this->engine = $engineFactory->buildFromCwd();
        $this->generator = $generator;
    }

    /**
     * Run the task.
     */
    public function __invoke(Command $command)
    {
        $welcomeView = new WelcomeView(
            $this->engine
        );

        $viewFile = str_replace(
            $this->engine->getEnginePath() . '/',
            '',
            $this->generator->generate($welcomeView)
        );

        $command->info('Welcome view generated.');
        $command->comment(" - $viewFile");
    }
}
