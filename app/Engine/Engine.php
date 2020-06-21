<?php

namespace PHLConsole\Engine;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class Engine
{
    /**
     * The string instance.
     *
     * @var string
     */
    protected $rawEngineName;

    /**
     * The string instance.
     *
     * @var string
     */
    protected $engineDirectory;

    /**
     * The Filesystem instance.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * EngineInfo constructor.
     */
    public function __construct(
        string $rawEngineName,
        string $engineDirectory,
        ?Filesystem $filesystem = null
    ) {
        $this->rawEngineName = $rawEngineName;
        $this->engineDirectory = $engineDirectory;
        $this->filesystem = $filesystem ?? new Filesystem();
    }

    /**
     * Return the engine's composer package name.
     */
    public function getPackageName(): string
    {
        return $this->rawEngineName;
    }

    /**
     * Return the engine's vendor name.
     */
    public function getVendorName(): string
    {
        return Str::studly(explode('/', $this->rawEngineName)[0]);
    }

    /**
     * Return the engine's name.
     */
    public function getEngineName(): string
    {
        return Str::studly(explode('/', $this->rawEngineName)[1]);
    }

    /**
     * Return the engine namespace.
     */
    public function getEngineNamespace(string $extra = null): string
    {
        $extra = $extra
            ? Str::start($extra, '\\')
            : '';

        return "{$this->getVendorName()}\\{$this->getEngineName()}" . $extra;
    }

    /**
     * Return the engine's test database name.
     */
    public function getEngineTestDatabaseName(): string
    {
        return Str::snake($this->getEngineName()) . '_tests';
    }

    /**
     * Return the engine's path.
     */
    public function getEnginePath(string $extra = null): string
    {
        $extra = $extra
            ? Str::start($extra, '/')
            : '';

        return $this->engineDirectory . $extra;
    }

    /**
     * Return the engine's service provider path.
     */
    public function getEngineServiceProviderPath(): string
    {
        return $this->getEnginePath(
            "src/{$this->getEngineName()}ServiceProvider.php"
        );
    }

    /**
     * Return the engine's directory name.
     */
    public function getDirectoryName(): string
    {
        return explode('/', $this->rawEngineName)[1];
    }

    /**
     * Add the load api routes call to the service provider.
     */
    public function addLoadApiRoutes(): void
    {
        $this->addToServiceProviderBoot('$this->loadApiRoutes();');
    }

    /**
     * Add the load web routes call to the service provider.
     */
    public function addLoadWebRoutes(): void
    {
        $this->addToServiceProviderBoot('$this->loadWebRoutes();');
    }

    /**
     * Add the load views call to the service provider.
     */
    public function addLoadViews()
    {
        $this->addToServiceProviderBoot('$this->loadViews();');
    }

    /**
     * Add one line to the boot method of the engine's service provider.
     */
    public function addToServiceProviderBoot(string $line): void
    {
        $serviceProvider = file_get_contents(
            $this->getEngineServiceProviderPath()
        );

        if (str_contains($serviceProvider, $line)) {
            return;
        }

        $updatedServiceProvider = str_replace(
            $start = "    public function boot()\n    {\n",
            $start . '        ' . trim($line) . "\n",
            $serviceProvider
        );

        $this->filesystem->put(
            $this->getEngineServiceProviderPath(),
            $updatedServiceProvider
        );
    }

    /**
     * Add one line to the register method of the engine's service provider.
     */
    public function addToServiceProviderRegister(string $line): void
    {
        $serviceProvider = file_get_contents(
            $this->getEngineServiceProviderPath()
        );

        if (str_contains($serviceProvider, $line)) {
            return;
        }

        $updatedServiceProvider = str_replace(
            $start = "    public function register()\n    {\n",
            $start . '        ' . trim($line) . "\n",
            $serviceProvider
        );

        $this->filesystem->put(
            $this->getEngineServiceProviderPath(),
            $updatedServiceProvider
        );
    }
}
