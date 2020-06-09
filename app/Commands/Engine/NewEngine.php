<?php

namespace App\Commands\Engine;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Filesystem\Filesystem;
use LaravelZero\Framework\Commands\Command;
use RuntimeException;
use Symfony\Component\Process\Process;
use ZipArchive;

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
    protected $description = 'Create a new engine of the given name';

    /**
     * The temporary directory for this run.
     *
     * @var string
     */
    protected $tempDir;

    /**
     * The Client instance.
     *
     * @var Client
     */
    protected $client;

    /**
     * The Filesystem instance.
     *
     * @var Filesystem
     */
    protected $fileSystem;

    /**
     * NewEngine constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->tempDir = getcwd() . '/' . uniqid('laravel_engine_install');

        $this->client = new Client([
            'headers' => [
                'Authorization' => 'token ' . env('GH_TOKEN')
            ]
        ]);

        $this->fileSystem = new Filesystem();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!extension_loaded('zip')) {
            throw new RuntimeException('The Zip PHP extension is not required. Please install it and try again.');
        }

        // Support no-ansi and quiet
        $enginePath = $this->getTargetDirectory();
        $this->makeSureDirectoryDoesNotExists($enginePath);

        try {
            $this->fileSystem->makeDirectory($this->tempDir);
            $this->info('🚀 Generating new Engine, sit tight.');

            $this->extractRelease(
                $this->downloadLatestRelease(),
                $enginePath
            );

            $this->composer('install', $enginePath);

            // Need to rename every service provider and stuff

            $this->getOutput()->writeln('');
            $this->info('🎉 Your engine is ready!');
            // Add info for next step
        } finally {
            $this->cleanUp();
        }
    }

    /**
     * Return the directory in which the engine should be created.
     */
    protected function getTargetDirectory(): string
    {
        $name = $this->argument('name');

        return $name && $name !== '.'
            ? getcwd() . '/' . $name
            : getcwd();
    }

    /**
     * Make sure we're not creating an engine in an already existing directory.
     */
    protected function makeSureDirectoryDoesNotExists(string $enginePath): void
    {
        if ($enginePath === getcwd()) {
            return;
        }

        if (is_dir($enginePath) || is_file($enginePath)) {
            // use --force to force installation
            $this->warn('Destination directory already exist.');
            exit(1);
        }
    }

    /**
     * Download and the latest release.
     */
    protected function downloadLatestRelease(): string
    {
        // We'll need to add support for specified versions later on.

        $target = $this->tempDir . '/' . 'laravel_engine_release';

        $response = $this->client->get(
            // Need to use personal url instead of github
            'https://api.github.com/repos/paulhenri-l/laravel-engine/releases/latest'
        );

        $latestRelease = $this->client->get(
            json_decode($response->getBody())->zipball_url
        );

        $this->fileSystem->put(
            $target, $latestRelease->getBody()
        );

        return $target;
    }

    /**
     * Extract the given release and return the path to the extracted contents.
     */
    protected function extractRelease(string $release, string $destination): void
    {
        $extractPath = $this->tempDir . '/extract';

        $zip = new ZipArchive();
        $zip->open($release, ZipArchive::CHECKCONS);
        $zip->extractTo($extractPath);
        $zip->close();

        $this->fileSystem->moveDirectory(
            $this->fileSystem->directories($extractPath)[0],
            $destination
        );
    }

    /**
     * Return the composer executable.
     */
    protected function composer(string $command, string $directory)
    {
        $composerPath = getcwd() . '/composer.phar';

        $composer = file_exists($composerPath)
            ? '"' . PHP_BINARY . '" ' . $composerPath
            : 'composer';

        $process = Process::fromShellCommandline(
            $composer . ' ' . $command,
            $directory,
            null,
            null,
            null
        );

        if (
            DIRECTORY_SEPARATOR !== '\\'
            && file_exists('/dev/tty')
            && is_readable('/dev/tty')
        ) {
            try {
                $process->setTty(true);
            } catch (RuntimeException $e) {
                $this->warn('Warning: ' . $e->getMessage());
            }
        }

        $process->run(function ($type, $line) {
            $this->getOutput()->writeln($line);
        });
    }

    /**
     * Remove our temporary files.
     */
    protected function cleanUp()
    {
        $this->fileSystem->deleteDirectory(
            $this->tempDir
        );
    }
}
