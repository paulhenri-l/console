<?php

namespace PHLConsole\Engine\Make\Generators;

class Notification extends EngineClassGenerator
{
    /**
     * Return the path to the class template.
     */
    protected function getTemplatePath(): string
    {
        return __DIR__ . '/stubs/notification.stub';
    }

    /**
     * Return the namespace for the new class.
     */
    function getTargetNamespace(): string
    {
        return 'Notifications';
    }
}
