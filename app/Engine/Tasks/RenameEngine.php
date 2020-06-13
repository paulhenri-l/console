<?php

namespace PHLConsole\Engine\Tasks;

use PHLConsole\Engine\EngineInfo;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\SplFileInfo;

class RenameEngine implements TaskInterface
{
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
        $engineFiles = $this->filesystem->allFiles(
            $engineInfo->getEnginePath()
        );

        foreach ($engineFiles as $file) {
            $command->info('Updating ' . $file->getFilename());
            $this->changeVendorAndPackageName($file, $engineInfo);
        }

        $this->updateComposerJson($engineInfo);
        $this->renameServiceProvider($engineInfo);
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
            'Vendor', $engineInfo->getVendorName(), $contents
        );

        $contents = str_replace(
            'EngineName', $engineInfo->getEngineName(), $contents
        );

        $this->filesystem->put(
            $file->getRealPath(), $contents
        );
    }

    /**
     * Change the package name inside the composer.json file
     */
    protected function updateComposerJson(EngineInfo $engineInfo): void
    {
        $contents = $this->filesystem->get(
            $composerJson = $engineInfo->getEnginePath() . '/' . 'composer.json'
        );

        $composerJsonData = json_decode($contents, true);

        $composerJsonData['name'] = $engineInfo->getPackageName();
        unset($composerJsonData['authors']);
        $composerJsonData['description'] = 'This is the next great package';


        $this->filesystem->put($composerJson, json_encode(
            $composerJsonData,
            JSON_FORCE_OBJECT|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES
        ));
    }

    /**
     * Rename the engine's ServiceProvider class.
     */
    protected function renameServiceProvider(EngineInfo $engineInfo): void
    {
        $this->filesystem->move(
            $engineInfo->getEnginePath('/src/EngineNameServiceProvider.php'),
            $engineInfo->getEnginePath(
                '/src/' . $engineInfo->getEngineName() . 'ServiceProvider.php'
            )
        );
    }
}
