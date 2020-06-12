<?php

namespace App\Engine;

use Throwable;

class DirectoryAlreadyExistsException extends \Exception
{
    /**
     * DirectoryAlreadyExistsException constructor.
     */
    public function __construct(
        $message = "",
        $code = 0,
        Throwable $previous = null
    ) {
        $message = "The [$message] directory already exists.";

        parent::__construct($message, $code, $previous);
    }
}
