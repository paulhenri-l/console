<?php

namespace App\Engine;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Symfony\Component\Process\Process;

class Initiator
{
    /**
     * The Filesystem instance.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Initiator constructor.
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Create a new engine of the given name in the given directory.
     */
    public function createNewEngine(string $engineName, string $directory)
    {
        $nameInfo = new NameInfo($engineName);

        $enginePath = Str::finish(
            $directory, "/{$nameInfo->getDirectoryName()}"
        );

        $this->createEngineDirectory($enginePath);
        $this->cloneBaseEngineRepository($enginePath);
        $this->renameEngine($nameInfo, $enginePath);
        $this->composerInstall($enginePath);
    }

    /**
     * Create the engine directory.
     */
    protected function createEngineDirectory(string $enginePath): void
    {
        if (is_dir($enginePath) || is_file($enginePath)) {
            throw new DirectoryAlreadyExistsException($enginePath);
        }

        $this->filesystem->makeDirectory($enginePath);
    }

    /**
     * Clone the base engine repository.
     */
    protected function cloneBaseEngineRepository(string $enginePath): void
    {
        $repo = 'https://github.com/paulhenri-l/laravel-engine.git';

        $this->runCommand("git clone {$repo} {$enginePath}");
        $this->runCommand("rm -rf {$enginePath}/.git");
    }

    /**
     * Rename the engine to the user provided name.
     */
    protected function renameEngine(NameInfo $nameInfo, string $enginePath)
    {
        $name = $nameInfo->getPackageName();
        $vendor = $nameInfo->getVendorName();

        foreach ($this->listEngineFiles($enginePath) as $file) {
            $this->runCommand(
                "sed -i.bak \"s/Vendor/{$vendor}/g\" {$file}"
            );

            $this->runCommand(
                "sed -i.bak \"s/EngineName/{$name}/g\" {$file}"
            );

            $this->filesystem->delete($file . '.bak');
        }

        $this->runCommand(
            "mv EngineNameServiceProvider.php {$name}ServiceProvider.php",
            Str::finish($enginePath, '/') . 'src'
        );
    }

    /**
     * Install the engine's composer dependencies.
     */
    protected function composerInstall(string $enginePath): void
    {
        $this->runCommand('composer install', $enginePath);
    }

    /**
     * Run the given command in the given directory.
     */
    protected function runCommand(string $command, string $directory = null)
    {
        $process = Process::fromShellCommandline(
            $command, $directory ?? getcwd(), null, null, null
        );

        try {
            $process->setTty(true);
        } catch (\RuntimeException $e) {
            //
        }

        $process->run(function ($type, $line) {
            echo $line . PHP_EOL;
        });
    }

    /**
     * List all of the engine's files.
     */
    protected function listEngineFiles(string $enginePath): array
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($enginePath)
        );

        $files = [];

        foreach ($iterator as $file) {
            if ($file->isDir()) {
                continue;
            }

            $files[] = $file->getPathname();
        }

        return $files;
    }
}
