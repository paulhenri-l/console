<?php

namespace Tests {
    function fakeCwd(string $newCwd = null)
    {
        static $cwd;

        if ($newCwd !== null) {
            $cwd = $newCwd;
        }

        return $cwd ?? \getcwd();
    }

    function getcwd()
    {
        return \Tests\fakeCwd();
    }
}

namespace PHLConsole\Commands\Engine {

    function getcwd()
    {
        return \Tests\fakeCwd();
    }
}

namespace PHLConsole\Engine\Tasks {

    function getcwd()
    {
        return \Tests\fakeCwd();
    }
}
