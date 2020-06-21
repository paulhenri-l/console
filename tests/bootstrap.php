<?php

require_once __DIR__ . '/../vendor/autoload.php';

(new \Illuminate\Filesystem\Filesystem())->deleteDirectory(
    __DIR__ . '/FakeCwd/fake-engine'
);
