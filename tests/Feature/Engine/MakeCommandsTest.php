<?php

namespace Tests\Feature\Engine;

use Illuminate\Support\Str;
use Tests\TestCase;

class MakeCommandsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->initFakeEngine();
    }

    public function generatorCommandsProvider(): array
    {
        return [
            ['controller', '\Http\Controllers'],
            ['cast', '\Casts'],
            ['channel', '\Channels'],
            ['command', '\Console\Commands'],
            ['event', '\Events'],
            ['exception', '\Exceptions'],
            ['job', '\Jobs'],
            ['mail', '\Mails'],
            ['middleware', '\Http\Middleware'],
            ['model', ''],
            ['notification', '\Notifications'],
            ['observer', '\Observers'],
        ];
    }

    /** @dataProvider generatorCommandsProvider */
    public function test_classes_can_be_generated(string $type, string $namespace)
    {
        $targetPath = str_replace('\\', '/', $namespace);

        $this->artisan("make:{$type}", ['name' => 'Hello/World'])
            ->expectsOutput(ucfirst($type) . ' generated.');

        $generatedClass = file_get_contents(
            \Tests\getcwd() . "/src/{$targetPath}/Hello/World.php"
        );

        $this->assertStringContainsString(
            "class World", $generatedClass
        );

        $this->assertStringContainsString(
            "namespace PaulhenriL\FakeEngine{$namespace}\Hello",
            $generatedClass
        );
    }

    /** @dataProvider generatorCommandsProvider */
    public function test_class_cannot_use_reserved_word(string $type, string $namespace)
    {
        $this->artisan("make:{$type}", ['name' => 'New'])
            ->assertExitCode(1);
    }

    /** @dataProvider generatorCommandsProvider */
    public function test_class_cannot_overwrite(string $type, string $namespace)
    {
        $this->artisan("make:{$type}", ['name' => 'Hello/World'])
            ->expectsOutput(ucfirst($type) . ' generated.');

        $this->artisan("make:{$type}", ['name' => 'Hello/World'])
            ->assertExitCode(1);
    }

    /** @dataProvider generatorCommandsProvider */
    public function test_class_can_force_overwrite(string $type, string $namespace)
    {
        $this->artisan("make:{$type}", ['name' => 'Hello/World'])
            ->expectsOutput(ucfirst($type) . ' generated.');

        $this->artisan("make:{$type}", ['name' => 'Hello/Wrold', '--force' => true])
            ->expectsOutput(ucfirst($type) . ' generated.')
            ->assertExitCode(0);
    }
}
