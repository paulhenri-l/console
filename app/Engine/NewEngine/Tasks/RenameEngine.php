<?php

namespace PHLConsole\Engine\NewEngine\Tasks;

use PHLConsole\Commands\Engine\NewEngine;
use PHLConsole\Engine\Engine;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\SplFileInfo;

class RenameEngine
{
    /**
     * The Engine instance.
     *
     * @var Engine
     */
    protected $engine;

    /**
     * The NewEngine command instance.
     *
     * @var NewEngine
     */
    protected $command;

    /**
     * The Filesystem instance.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * RenameEngine constructor.
     */
    public function __construct(Engine $engine, Filesystem $filesystem = null)
    {
        $this->engine = $engine;
        $this->filesystem = $filesystem ?? new Filesystem();
    }

    /**
     * Rename the base engine's stubs.
     */
    public function __invoke(Command $command)
    {
        $this->command = $command;

        $this->updateStubs();
        $this->createReadme();
        $this->updateComposerJson();
        $this->renameServiceProvider();
    }

    /**
     * Rename stubs in the engine's files.
     */
    protected function updateStubs(): void
    {
        $this->command->info('Updating stubs...');
        $this->engineFiles = $this->filesystem->allFiles(
            $this->engine->getEnginePath()
        );

        $this->engineFiles = array_merge($this->filesystem->allFiles(
            $this->engine->getEnginePath('.github')
        ), $this->engineFiles);

        foreach ($this->engineFiles as $file) {
            if (!$this->needsUpdating($file)) {
                continue;
            }

            $this->changeVendorAndPackageName($file, $this->engine);
            $this->command->comment("  {$file->getFilename()} updated");
        }
    }

    /**
     * Create the engine's README.
     */
    protected function createReadme()
    {
        $this->command->info('Creating README.md');

        $readmePath = $this->engine->getEnginePath('README.md');

        $this->filesystem->delete($readmePath);

        $this->filesystem->put(
            $readmePath, "# {$this->engine->getEngineName()}" . PHP_EOL
        );

        $this->command->comment('  README.md created');
    }

    /**
     * Change the package name inside the composer.json file
     */
    protected function updateComposerJson(): void
    {
        $this->command->info('Updating composer.json');

        $contents = $this->filesystem->get(
            $composerJson = $this->engine->getEnginePath('composer.json')
        );

        $composerJsonData = json_decode($contents, true);

        $composerJsonData['name'] = $this->engine->getPackageName();
        unset($composerJsonData['authors']);
        $composerJsonData['description'] = 'This is the next great package';


        $this->filesystem->put($composerJson, json_encode(
            $composerJsonData,
            JSON_FORCE_OBJECT | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        ));
        $this->command->comment('  composer.json contents updated.');
    }

    /**
     * Rename the engine's ServiceProvider class.
     */
    protected function renameServiceProvider(): void
    {
        $this->command->info('Renaming ServiceProvider');

        $targetServiceProvider = $this->engine->getEnginePath(
            $spPath = 'src' . DIRECTORY_SEPARATOR . $this->engine->getEngineName() . 'ServiceProvider.php'
        );

        $this->filesystem->move(
            $this->engine->getEnginePath('src/EngineNameStubServiceProvider.php'),
            $targetServiceProvider
        );

        $this->command->comment("  Service provider moved to {$spPath}");
    }

    /**
     * Change the stub vendor and package name.
     */
    protected function changeVendorAndPackageName(SplFileInfo $file): void
    {
        $contents = $file->getContents();

        $contents = str_replace(
            'VendorStub', $this->engine->getVendorName(), $contents
        );

        $contents = str_replace(
            'EngineNameStub', $this->engine->getEngineName(), $contents
        );

        $contents = str_replace(
            'engine_name_stub_tests',
            $this->engine->getEngineTestDatabaseName(),
            $contents
        );

        $this->filesystem->put(
            $file->getRealPath(), $contents
        );
    }

    /**
     * Does the given file needs to get its content updated?
     */
    protected function needsUpdating(SplFileInfo $file): bool
    {
        $contents = $file->getContents();

        return str_contains($contents, 'VendorStub')
            || str_contains($contents, 'EngineNameStub')
            || str_contains($contents, 'engine_name_stub_tests');
    }
}
