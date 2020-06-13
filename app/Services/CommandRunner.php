<?php

namespace PHLConsole\Services;

use Symfony\Component\Process\Process;

class CommandRunner
{
    /**
     * Run the given command in the given directory and redirect its output to
     * the given closure.
     */
    public function run(string $command, string $directory, callable $output)
    {
        $process = Process::fromShellCommandline(
            $command, $directory, null, null, null
        );

        try {
            $process->setTty(true);
        } catch (\RuntimeException $e) {
            //
        }

        $process->run(function ($type, $line) use ($output) {
            $output($line);
        });
    }
}
