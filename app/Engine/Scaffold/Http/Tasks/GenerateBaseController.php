<?php

namespace PHLConsole\Engine\Scaffold\Http\Tasks;

use Illuminate\Console\Command;
use PHLConsole\Engine\Engine;
use PHLConsole\Engine\EngineFactory;
use PHLConsole\Engine\Scaffold\Http\Generators\BaseController;
use PHLConsole\Generator\Generator;

class GenerateBaseController
{
    /**
     * The EngineInfo instance.
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
     * GenerateBaseController constructor.
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
        // Check if it does already exists
        $baseController = new BaseController(
            $this->engine
        );

        $file = str_replace(
            $this->engine->getEnginePath() . '/',
            '',
            $this->generator->generate($baseController)
        );

        $command->info('Base controller generated.');
        $command->comment(" - $file");
    }
}
