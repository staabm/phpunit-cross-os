<?php

namespace staabm\PHPUnitCrossOs\Comparator;

use function PHPUnit\Framework\assertIsString;
use SebastianBergmann\Comparator\Comparator;
use SebastianBergmann\Comparator\ComparisonFailure;

final class EolAgnosticStringComparator extends Comparator
{
    public function accepts($expected, $actual)
    {
        return \is_string($expected) && \is_string($actual);
    }

    /**
     * @return void
     */
    public function assertEquals($expected, $actual, $delta = 0.0, $canonicalize = false, $ignoreCase = false)
    {
        assertIsString($actual);
        assertIsString($expected);

        $expected = new EolAgnosticString($expected);
        $actual = new EolAgnosticString($actual);

        $expected = $expected->getNormalized();
        $actual = $actual->getNormalized();

        if ($ignoreCase) {
            if (0 !== strcasecmp($expected, $actual)) {
                throw new ComparisonFailure($expected, $actual, $expected, $actual);
            }
        } else {
            if (0 !== strcmp($expected, $actual)) {
                throw new ComparisonFailure($expected, $actual, $expected, $actual);
            }
        }
    }
}
