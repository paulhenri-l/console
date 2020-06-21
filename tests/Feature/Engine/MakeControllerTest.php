<?php

namespace Tests\Feature\Engine;

use Tests\TestCase;

class MakeControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->initFakeEngine();
    }

    public function test_controllers_can_be_generated()
    {
        $this->artisan('make:controller', ['name' => 'Hello/WorldController'])
            ->expectsOutput('Controller generated.');

        $generatedController = file_get_contents(
            \Tests\getcwd() . '/src/Http/Controllers/Hello/WorldController.php'
        );

        $this->assertStringContainsString(
            "WorldController\n",
            $generatedController
        );

        $this->assertStringContainsString(
            'namespace PaulhenriL\FakeEngine\Http\Controllers\Hello',
            $generatedController
        );
    }

    public function test_controller_cannot_use_reserved_word()
    {
        $this->artisan('make:controller', ['name' => 'New'])
            ->assertExitCode(1);
    }

    public function test_controller_cannot_overwrite()
    {
        $this->artisan('make:controller', ['name' => 'Hello/WorldController'])
            ->expectsOutput('Controller generated.');

        $this->artisan('make:controller', ['name' => 'Hello/WorldController'])
            ->assertExitCode(1);
    }

    public function test_controller_can_force_overwrite()
    {
        $this->artisan('make:controller', ['name' => 'Hello/WorldController'])
            ->expectsOutput('Controller generated.');

        $this->artisan('make:controller', ['name' => 'Hello/WorldController', '--force' => true])
            ->expectsOutput('Controller generated.')
            ->assertExitCode(0);
    }
}
