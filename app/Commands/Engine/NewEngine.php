<?php

namespace App\Commands\Engine;

use App\Engine\Initiator;
use LaravelZero\Framework\Commands\Command;

class NewEngine extends Command
{
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
    protected $description = 'Create a new engine of the given name the name must be specified in the vendor/package-name format.';

    /**
     * The Initiator instance.
     *
     * @var Initiator
     */
    protected $initiator;

    /**
     * NewEngine constructor.
     */
    public function __construct(Initiator $initiator)
    {
        parent::__construct();

        $this->initiator = $initiator;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Generating new Engine, sit tight.');

        $this->initiator->createNewEngine(
            $this->getEngineName(), getcwd()
        );

        $this->info('🎉 Your engine is ready!');
    }

    /**
     * Validate and return the engine name.
     */
    protected function getEngineName()
    {
        return $this->argument('name');
    }
}
