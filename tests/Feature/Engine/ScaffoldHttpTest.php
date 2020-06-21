<?php

namespace Tests\Feature\Engine;

use Tests\TestCase;
use function \Tests\getcwd;

class ScaffoldHttpTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->initFakeEngine();
    }

    public function test_http_layer_can_be_scaffoled()
    {
        $this->artisan('scaffold:http')->assertExitCode(0);

        $this->assertFileExists(getcwd() . '/src/Http/Controllers/Controller.php');
        $this->assertFileExists(getcwd() . '/resources/views/welcome.php');
        $this->assertFileExists(getcwd() . '/routes/api.php');
        $this->assertFileExists(getcwd() . '/routes/web.php');

        $updatedServiceProvider = file_get_contents(
            getcwd() . '/src/FakeEngineServiceProvider.php'
        );

        $this->assertStringContainsString(
            '$this->loadWebRoutes();',
            $updatedServiceProvider
        );

        $this->assertStringContainsString(
            '$this->loadApiRoutes();',
            $updatedServiceProvider
        );

        $this->assertStringContainsString(
            '$this->loadViews();',
            $updatedServiceProvider
        );
    }
}
