<?php

namespace Tests\Feature\Engine;

use Illuminate\Filesystem\Filesystem;
use PHLConsole\Engine\Engine;
use Tests\TestCase;

class NewEngineTest extends TestCase
{
    public function test_that_new_engines_can_be_generated()
    {
        $engine = new Engine('phl/test-engine', \Tests\getcwd() . '/test-engine');

        $this->artisan(
            'new:engine', ['name' => 'phl/test-engine']
        )->assertExitCode(0);

        $this->assertFileExists($engine->getEnginePath('src/TestEngineServiceProvider.php'));
        $this->assertFileNotExists($engine->getEnginePath('LICENSE'));
        $this->assertFileContains('phl/test-engine', $engine->getEnginePath('composer.json'));
        $this->assertFileContains('TestEngine', $engine->getEnginePath('README.md'));
        $this->assertFileContains('namespace Phl\\TestEngine', $engine->getEnginePath('src/TestEngineServiceProvider.php'));
        $this->assertFileContains('test_engine_tests', $engine->getEnginePath('phpunit.xml'));
        $this->assertFileContains('test_engine_tests', $engine->getEnginePath('.github/workflows/tests.yml'));
        $this->assertDirectoryExists($engine->getEnginePath('vendor'));
    }

    public function test_engine_name_format_is_validated()
    {
        $this->artisan(
            'new:engine', ['name' => 'bad-name']
        )->assertExitCode(1);
    }

    public function test_engine_cannot_be_created_on_existing_directory()
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
