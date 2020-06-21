<?php

namespace PHLConsole\Commands\Engine;

use LaravelZero\Framework\Commands\Command;
use PaulhenriL\LaravelTaskRunner\CanRunTasks;
use PHLConsole\Engine\Scaffold\Http\Tasks\AddRoutes;
use PHLConsole\Engine\Scaffold\Http\Tasks\AddViews;
use PHLConsole\Engine\Scaffold\Http\Tasks\EditServiceProvider;
use PHLConsole\Engine\Scaffold\Http\Tasks\Enjoy;
use PHLConsole\Engine\Scaffold\Http\Tasks\GenerateBaseController;
use PaulhenriL\Generator\Generator;

class ScaffoldHttp extends Command
{
    use CanRunTasks;

    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'scaffold:http';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Add the http layer to your engine';

    /**
     * The Generator instance.
     *
     * @var Generator
     */
    protected $generator;

    /**
     * ScaffoldHttp constructor.
     */
    public function __construct(Generator $generator) {
        parent::__construct();
        $this->generator = $generator;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("🧙‍ Scaffolding the engine's http layer...");
        $this->line('');

        $this->runTasks([
            app(GenerateBaseController::class),
            app(AddRoutes::class),
            app(AddViews::class),
            app(EditServiceProvider::class),
            app(Enjoy::class)
        ]);

        $this->line('');
    }
}
