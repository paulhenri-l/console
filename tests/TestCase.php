<?php

namespace Tests;

use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;
use LaravelZero\Framework\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /** @var Carbon */
    protected $now;

    protected function setUp(): void
    {
        $this->now = Carbon::createFromFormat(
            'Y-m-d H:i:s', '2020-01-01 00:00:00'
        );

        Carbon::setTestNow($this->now);

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
