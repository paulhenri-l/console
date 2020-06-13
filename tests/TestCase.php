<?php

namespace Tests;

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
}
