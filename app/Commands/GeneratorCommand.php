<?php

namespace PHLConsole\Commands;

use LaravelZero\Framework\Commands\Command;
use PaulhenriL\Generator\Generator;
use PaulhenriL\Generator\GeneratorSpecification;
use PaulhenriL\Generator\Keywords;
use PHLConsole\Engine\EngineFactory;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

abstract class GeneratorCommand extends Command
{
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
        $this->signature = $this->signature();
        $this->description = $this->description();

        parent::__construct();

        $this->specifyParameters();
        $this->generator = $generator;
        $this->engineFactory = $engineFactory;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->inputName();

        if (Keywords::isReserved($name)) {
            $this->error("The name '{$name}' is reserved by PHP.");
            return 1;
        }

        $spec = $this->buildSpecification();

        if (!$this->option('force') && file_exists($spec->getTargetPath())) {
            $this->error("The '{$name}' file already exists use --force to overwrite.");
            return 1;
        }

        $this->generator->generate($spec);

        $this->info($this->generatedType() . ' generated.');

        return 0;
    }

    /**
     * Build the file specification.
     */
    protected function buildSpecification(): GeneratorSpecification
    {
        $engine = $this->engineFactory->buildFromCwd();

        $specClass = $this->specification();

        return new $specClass(
            $engine, $this->inputName()
        );
    }

    /**
     * The name of the file to generate.
     */
    protected function inputName(): string
    {
        return $this->argument('name');
    }

    /**
     * The generated file type.
     */
    protected function generatedType(): string
    {
        $signature = trim($this->signature());

        if (str_contains($signature, ':')) {
            return ucfirst(explode(':', $signature)[1]);
        }

        return ucfirst(explode(' ', $signature)[0]);
    }

    /**
     * Get the console command arguments.
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the file to generate'],
        ];
    }

    /**
     * Get the console command options.
     */
    protected function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'force creation']
        ];
    }

    /**
     * The command signature.
     */
    abstract protected function signature(): string;

    /**
     * The command description.
     */
    abstract protected function description(): string;

    /**
     * The file specification classname.
     */
    abstract protected function specification(): string;
}
