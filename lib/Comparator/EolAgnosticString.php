<?php

namespace staabm\PHPUnitCrossOs\Comparator;

final class EolAgnosticString
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
        return str_replace("\r\n", "\n", $this->string);
    }
}
