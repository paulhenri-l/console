<?php

namespace Tests;

use Illuminate\Filesystem\Filesystem;
use LaravelZero\Framework\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        putenv('DISABLE_TTY=1');
        fakeCwd(realpath(__DIR__ . '/FakeCwd'));

        parent::setUp();
    }

    protected function initFakeEngine()
    {
        $fakeEngine = getcwd() . '/fake-engine';

        if (!is_dir($fakeEngine)) {
            $this->artisan('new:engine', ['name' => 'paulhenri-l/fake-engine']);
        }

        (new Filesystem())->copyDirectory(
            $fakeEngine,
            $currentFakeEngine = getcwd() . '/current-fake-engine'
        );

        $this->beforeApplicationDestroyed(function () use ($currentFakeEngine, $fakeEngine) {
            (new Filesystem())->deleteDirectory(
                $currentFakeEngine
            );
        });

        fakeCwd(getcwd() . '/current-fake-engine');
    }
}
