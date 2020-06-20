<?php

namespace PHLConsole\Generator;

use Illuminate\Filesystem\Filesystem;

class Generator
{
    /**
     * The Filesystem instance.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Generator constructor.
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Generate a new file by using the given spec.
     */
    public function generate(GeneratorSpecification $spec): string
    {
        $template = $spec->getTemplate();

        $template = $this->performReplacements(
            $template, $spec->getReplacements()
        );

        $template = $this->passThroughProcessors(
            $template, $spec->getProcessors()
        );

        return $this->writeFile(
            $template, $spec->getTargetPath()
        );
    }

    /**
     * Replace placeholder in the given template.
     */
    protected function performReplacements(
        string $template,
        array $replacements
    ): string {
        foreach ($replacements as $key => $replacement) {
            $template = str_replace(
                "{{ {$key} }}", $replacement, $template
            );
        }

        return $template;
    }

    /**
     * Pass the template through the given set of processors.
     */
    protected function passThroughProcessors(
        string $template,
        array $processors
    ): string {
        foreach ($processors as $processor) {
            $template = $processor($template);
        }

        return $template;
    }

    /**
     * Write the given template to the given path.
     */
    protected function writeFile(string $template, string $targetPath): string
    {
        $this->filesystem->ensureDirectoryExists(
            dirname($targetPath)
        );

        $this->filesystem->put(
            $targetPath, $template
        );

        return $targetPath;
    }
}
