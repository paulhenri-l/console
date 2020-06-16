<?php

namespace Tests\Feature;

use Illuminate\Filesystem\Filesystem;
use PHLConsole\Engine\EngineInfo;
use Tests\TestCase;

class NewEngineTest extends TestCase
{
    public function test_that_new_engines_can_be_generated()
    {
        $engineInfo = new EngineInfo('phl/test-engine', \Tests\getcwd());

        $this->artisan(
            'new:engine', ['name' => 'phl/test-engine']
        )->assertExitCode(0);

        $this->assertFileExists($engineInfo->getEnginePath('src/TestEngineServiceProvider.php'));
        $this->assertFileNotExists($engineInfo->getEnginePath('LICENSE'));
        $this->assertFileContains('phl/test-engine', $engineInfo->getEnginePath('composer.json'));
        $this->assertFileContains('TestEngine', $engineInfo->getEnginePath('README.md'));
        $this->assertFileContains('namespace Phl\\TestEngine', $engineInfo->getEnginePath('src/TestEngineServiceProvider.php'));
        $this->assertFileContains('test_engine_tests', $engineInfo->getEnginePath('phpunit.xml'));
        $this->assertFileContains('test_engine_tests', $engineInfo->getEnginePath('.github/workflows/tests.yml'));
        $this->assertDirectoryExists($engineInfo->getEnginePath('vendor'));
    }

    public function test_engine_name_format_is_validated()
    {
        $this->artisan(
            'new:engine', ['name' => 'bad-name']
        )->assertExitCode(1);
    }

    public function test_engine_cannot_be_created_on_exisiting_directory()
    {
        (new Filesystem)->makeDirectory(
            \Tests\getcwd() . DIRECTORY_SEPARATOR . 'test-engine'
        );

        $this->artisan(
            'new:engine', ['name' => 'phl/test-engine']
        )->assertExitCode(1);
    }

    protected function assertFileContains(string $needle, string $file)
    {
        $composer = file_get_contents($file);

        $this->assertStringContainsString($needle, $composer);
    }

    protected function tearDown(): void
    {
        (new Filesystem)->deleteDirectory(
            \Tests\getcwd() . DIRECTORY_SEPARATOR . 'test-engine'
        );

        parent::tearDown();
    }
}
