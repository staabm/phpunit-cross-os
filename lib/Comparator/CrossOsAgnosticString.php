<?php

namespace staabm\PHPUnitCrossOs\Comparator;

final class CrossOsAgnosticString
{
    /**
     * @var string
     */
    private $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }

    public function getNormalized()
    {
        $s = str_replace('\\', '/', $this->string);
        $s = str_replace("\r\n", "\n", $s);

        return $s;
    }
}
