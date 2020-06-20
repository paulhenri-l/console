<?php

namespace PHLConsole\Generator;

class SortUsesProcessor
{
    /**
     * Sort use statements in the given template.
     */
    public function __invoke(string $template): string
    {
        if (preg_match('/(?P<imports>(?:use [^;]+;$\n?)+)/m', $template, $match)) {
            $imports = explode("\n", trim($match['imports']));

            sort($imports);

            return str_replace(
                trim($match['imports']),
                implode("\n", $imports),
                $template
            );
        }

        return $template;
    }
}
