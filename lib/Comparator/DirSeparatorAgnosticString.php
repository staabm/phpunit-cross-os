<?php

namespace staabm\PHPUnitCrossOs\Comparator;

final class DirSeparatorAgnosticString
{
    /**
     * @var string
     */
    private $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }

    public function getNormalized(): string
    {
        return str_replace('\\', '/', $this->string);
    }
}
