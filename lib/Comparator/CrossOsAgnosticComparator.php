<?php

namespace staabm\PHPUnitCrossOs\Comparator;

use function PHPUnit\Framework\assertIsString;
use function PHPUnit\Framework\assertTrue;
use SebastianBergmann\Comparator\Comparator;
use SebastianBergmann\Comparator\ComparisonFailure;

final class CrossOsAgnosticComparator extends Comparator
{
    public function accepts($expected, $actual)
    {
        return ($expected instanceof CrossOsAgnosticString || $expected instanceof EolAgnosticString || $expected instanceof DirSeparatorAgnosticString) && \is_string($actual);
    }

    /**
     * @return void
     */
    public function assertEquals($expected, $actual, $delta = 0.0, $canonicalize = false, $ignoreCase = false)
    {
        assertTrue($expected instanceof CrossOsAgnosticString || $expected instanceof EolAgnosticString || $expected instanceof DirSeparatorAgnosticString);
        assertIsString($actual);

        $expected = $expected->getNormalized();
        $actual = new CrossOsAgnosticString($actual);
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
