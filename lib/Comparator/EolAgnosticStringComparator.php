<?php

namespace staabm\PHPUnitCrossOs\Comparator;

use SebastianBergmann\Comparator\Comparator;
use SebastianBergmann\Comparator\ComparisonFailure;
use function PHPUnit\Framework\assertIsString;

final class EolAgnosticStringComparator extends Comparator {
    public function accepts($expected, $actual)
    {
        return is_string($expected) && is_string($actual);
    }

    /**
     * @return void
     */
    public function assertEquals($expected, $actual, $delta = 0.0, $canonicalize = false, $ignoreCase = false) {
        assertIsString($actual);
        assertIsString($expected);

        $expected = str_replace("\r\n", "\n", $expected);
        $actual = str_replace("\r\n", "\n", $actual);

        if ($ignoreCase) {
            if (strcasecmp($expected, $actual) !== 0) {
                throw new ComparisonFailure($expected, $actual, $expected, $actual);
            }
        } else {
            if (strcmp($expected, $actual) !== 0) {
                throw new ComparisonFailure($expected, $actual, $expected, $actual);
            }
        }
    }
}