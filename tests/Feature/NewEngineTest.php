<?php

namespace Tests\Feature;

use Illuminate\Filesystem\Filesystem;
use Tests\TestCase;

class NewEngineTest extends TestCase
{
    public function test_that_new_engines_can_be_generated()
    {
        $enginePath = \Tests\getcwd() . '/test-engine';

        $this->artisan(
            'new:engine', ['name' => 'phl/test-engine']
        )->assertExitCode(0);

        $this->assertFileExists($enginePath . '/src/TestEngineServiceProvider.php');
        $this->assertFileNotExists($enginePath . '/LICENSE');
        $this->assertFileContains('phl/test-engine', $enginePath . '/composer.json');
        $this->assertFileContains('namespace Phl\\TestEngine', $enginePath . '/src/TestEngineServiceProvider.php');
        $this->assertDirectoryExists($enginePath . '/vendor');
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
            \Tests\getcwd() . '/test-engine'
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
        (new Filesystem)->deleteDirectory(\Tests\getcwd() . '/test-engine');

        parent::tearDown();
    }
}
