<?php

namespace PHLConsole\Generator;

interface GeneratorSpecification
{
    /**
     * The template to use for generation.
     */
    public function getTemplate(): string;

    /**
     * Return the target path for the generated file.
     */
    public function getTargetPath(): string;

    /**
     * Return the replacements
     */
    public function getReplacements(): array;

    /**
     * Return template processors.
     */
    public function getProcessors(): array;
}
