<?php

namespace PHLConsole\Engine\Tasks;

use PHLConsole\Commands\Engine\NewEngine;
use PHLConsole\Engine\EngineInfo;
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
    public function run(Command $command, EngineInfo $engineInfo): void
    {
        $this->command = $command;

        $this->updateStubs($engineInfo);
        $this->createReadme($engineInfo);
        $this->updateComposerJson($engineInfo);
        $this->renameServiceProvider($engineInfo);
    }

    /**
     * Rename stubs in the engine's files.
     */
    protected function updateStubs(EngineInfo $engineInfo): void
    {
        $this->command->info('Updating stubs...');
        $engineFiles = $this->filesystem->allFiles(
            $engineInfo->getEnginePath()
        );

        foreach ($engineFiles as $file) {
            if (!$this->needsUpdating($file)) {
                continue;
            }

            $this->changeVendorAndPackageName($file, $engineInfo);
            $this->command->comment("  {$file->getFilename()} updated");
        }
    }

    /**
     * Create the engine's README.
     */
    protected function createReadme(EngineInfo $engineInfo)
    {
        $this->command->info('Creating README.md');

        $readmePath = $engineInfo->getEnginePath('README.md');

        $this->filesystem->delete($readmePath);

        $this->filesystem->put(
            $readmePath, "# {$engineInfo->getEngineName()}" . PHP_EOL
        );

        $this->command->comment('  README.md created');
    }

    /**
     * Change the package name inside the composer.json file
     */
    protected function updateComposerJson(EngineInfo $engineInfo): void
    {
        $this->command->info('Updating composer.json');

        $contents = $this->filesystem->get(
            $composerJson = $engineInfo->getEnginePath() . '/' . 'composer.json'
        );

        $composerJsonData = json_decode($contents, true);

        $composerJsonData['name'] = $engineInfo->getPackageName();
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
    protected function renameServiceProvider(EngineInfo $engineInfo): void
    {
        $this->command->info('Renaming ServiceProvider');

        $targetServiceProvider = $engineInfo->getEnginePath(
            $spPath = 'src/' . $engineInfo->getEngineName() . 'ServiceProvider.php'
        );

        $this->filesystem->move(
            $engineInfo->getEnginePath('/src/EngineNameStubServiceProvider.php'),
            $targetServiceProvider
        );

        $this->command->comment("  Service provider moved to {$spPath}");
    }

    /**
     * Change the stub vendor and package name.
     */
    protected function changeVendorAndPackageName(
        SplFileInfo $file,
        EngineInfo $engineInfo
    ): void {
        $contents = $file->getContents();

        $contents = str_replace(
            'VendorStub', $engineInfo->getVendorName(), $contents
        );

        $contents = str_replace(
            'EngineNameStub', $engineInfo->getEngineName(), $contents
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
            || str_contains($contents, 'EngineNameStub');
    }
}
