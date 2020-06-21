<?php

namespace PHLConsole\Generator;

class SingleUseSpecification implements GeneratorSpecification
{
    /**
     * The template string.
     *
     * @var string
     */
    protected $template;

    /**
     * The target path for the generated file.
     *
     * @var string
     */
    protected $targetPath;

    /**
     * Array of template replacements.
     *
     * @var array
     */
    protected $replacements;

    /**
     * Array of callable processors.
     *
     * @var array
     */
    protected $processors;

    /**
     * ThrowAwayGenerator constructor.
     */
    public function __construct(
        string $template,
        string $targetPath,
        array $replacements,
        array $processors
    ) {
        $this->template = $template;
        $this->targetPath = $targetPath;
        $this->replacements = $replacements;
        $this->processors = $processors;
    }

    /**
     * The template to use for generation.
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * Return the target path for the generated file.
     */
    public function getTargetPath(): string
    {
        return $this->targetPath;
    }

    /**
     * Return the replacements
     */
    public function getReplacements(): array
    {
        return $this->replacements;
    }

    /**
     * Return template processors.
     */
    public function getProcessors(): array
    {
        return $this->processors;
    }
}
