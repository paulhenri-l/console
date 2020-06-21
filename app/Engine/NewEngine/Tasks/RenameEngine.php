<?php

namespace PHLConsole\Engine\NewEngine\Tasks;

use PHLConsole\Commands\Engine\NewEngine;
use PHLConsole\Engine\Engine;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\SplFileInfo;

class RenameEngine implements TaskInterface
{
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
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Rename the base engine's stubs.
     */
    public function run(Command $command, Engine $engine): void
    {
        $this->command = $command;

        $this->updateStubs($engine);
        $this->createReadme($engine);
        $this->updateComposerJson($engine);
        $this->renameServiceProvider($engine);
    }

    /**
     * Rename stubs in the engine's files.
     */
    protected function updateStubs(Engine $engine): void
    {
        $this->command->info('Updating stubs...');
        $engineFiles = $this->filesystem->allFiles(
            $engine->getEnginePath()
        );

        $engineFiles = array_merge($this->filesystem->allFiles(
            $engine->getEnginePath('.github')
        ), $engineFiles);

        foreach ($engineFiles as $file) {
            if (!$this->needsUpdating($file)) {
                continue;
            }

            $this->changeVendorAndPackageName($file, $engine);
            $this->command->comment("  {$file->getFilename()} updated");
        }
    }

    /**
     * Create the engine's README.
     */
    protected function createReadme(Engine $engine)
    {
        $this->command->info('Creating README.md');

        $readmePath = $engine->getEnginePath('README.md');

        $this->filesystem->delete($readmePath);

        $this->filesystem->put(
            $readmePath, "# {$engine->getEngineName()}" . PHP_EOL
        );

        $this->command->comment('  README.md created');
    }

    /**
     * Change the package name inside the composer.json file
     */
    protected function updateComposerJson(Engine $engine): void
    {
        $this->command->info('Updating composer.json');

        $contents = $this->filesystem->get(
            $composerJson = $engine->getEnginePath('composer.json')
        );

        $composerJsonData = json_decode($contents, true);

        $composerJsonData['name'] = $engine->getPackageName();
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
    protected function renameServiceProvider(Engine $engine): void
    {
        $this->command->info('Renaming ServiceProvider');

        $targetServiceProvider = $engine->getEnginePath(
            $spPath = 'src' . DIRECTORY_SEPARATOR . $engine->getEngineName() . 'ServiceProvider.php'
        );

        $this->filesystem->move(
            $engine->getEnginePath('src/EngineNameStubServiceProvider.php'),
            $targetServiceProvider
        );

        $this->command->comment("  Service provider moved to {$spPath}");
    }

    /**
     * Change the stub vendor and package name.
     */
    protected function changeVendorAndPackageName(
        SplFileInfo $file,
        Engine $engine
    ): void {
        $contents = $file->getContents();

        $contents = str_replace(
            'VendorStub', $engine->getVendorName(), $contents
        );

        $contents = str_replace(
            'EngineNameStub', $engine->getEngineName(), $contents
        );

        $contents = str_replace(
            'engine_name_stub_tests',
            $engine->getEngineTestDatabaseName(),
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
