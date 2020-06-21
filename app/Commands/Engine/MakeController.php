<?php

namespace PHLConsole\Commands\Engine;

use LaravelZero\Framework\Commands\Command;
use PHLConsole\Engine\EngineFactory;
use PHLConsole\Engine\Make\Generators\Controller;
use PaulhenriL\Generator\Generator;
use PaulhenriL\Generator\Keywords;

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
     * The EngineFactory instance.
     *
     * @var EngineFactory
     */
    protected $engineFactory;

    /**
     * MakeController constructor.
     */
    public function __construct(
        Generator $generator,
        EngineFactory $engineFactory
    ) {
        parent::__construct();
        $this->generator = $generator;
        $this->engineFactory = $engineFactory;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $engine = $this->engineFactory->buildFromCwd();

        if (Keywords::isReserved($name)) {
            $this->error("The name '{$name}' is reserved by PHP.");
            return 1;
        }

        $controllerSpec = new Controller(
            $engine, $this->argument('name')
        );

        if (!$this->option('force') && file_exists($controllerSpec->getTargetPath())) {
            $this->error("The '{$name}' controller already exists use --force to overwrite.");
            return 1;
        }

        $this->generator->generate($controllerSpec);

        $this->info('Controller generated.');

        return 0;
    }
}
