<?php

namespace Tests\Feature\Engine;

use Tests\TestCase;

class MakeFileCommandsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->initFakeEngine();
    }

    public function generatorCommandsProvider(): array
    {
        return [
            ['migration', "database/migrations/2020_01_01_000000_hello.php"],
        ];
    }

    /** @dataProvider generatorCommandsProvider */
    public function test_file_can_be_generated(string $type, string $expectedFile)
    {
        $this->artisan("make:{$type}", ['name' => 'Hello'])
            ->expectsOutput(ucfirst($type) . ' generated.');

        $this->assertFileExists(
            \Tests\getcwd() . '/' . $expectedFile
        );
    }

    /** @dataProvider generatorCommandsProvider */
    public function test_file_cannot_use_reserved_word(string $type, string $expectedFile)
    {
        $this->artisan("make:{$type}", ['name' => 'New'])
            ->assertExitCode(1);
    }

    /** @dataProvider generatorCommandsProvider */
    public function test_file_cannot_overwrite(string $type, string $expectedFile)
    {
        $this->artisan("make:{$type}", ['name' => 'Hello'])
            ->expectsOutput(ucfirst($type) . ' generated.');

        $this->artisan("make:{$type}", ['name' => 'Hello'])
            ->assertExitCode(1);
    }

    /** @dataProvider generatorCommandsProvider */
    public function test_file_can_force_overwrite(string $type, string $expectedFile)
    {
        $this->artisan("make:{$type}", ['name' => 'Hello'])
            ->expectsOutput(ucfirst($type) . ' generated.');

        $this->artisan("make:{$type}", ['name' => 'Hello', '--force' => true])
            ->expectsOutput(ucfirst($type) . ' generated.')
            ->assertExitCode(0);
    }
}
