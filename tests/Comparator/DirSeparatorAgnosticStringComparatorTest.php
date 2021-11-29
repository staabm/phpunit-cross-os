<?php

namespace staabm\Tests\PHPUnitCrossOs\Comparator;

use PHPUnit\Framework\TestCase;
use SebastianBergmann\Comparator\ComparisonFailure;
use staabm\PHPUnitCrossOs\Comparator\DirSeparatorAgnosticStringComparator;

final class DirSeparatorAgnosticStringComparatorTest extends TestCase {
    public function dataEqualProvider() {
        return [
            // ignore case
            ["hello/world", "hello\\WORLD", true],
            ["hello/world", "hello/WORLD", true],
            ["hello\\world", "hello\\WORLD", true],

            // case-sensitive
            ["hello/world", "hello\\world", true],
            ["hello/world", "hello/world", true],
            ["hello\\world", "hello\\world", true],
            ["hello/world", "hello\\world", false],
            ["hello/world", "hello/world", false],
            ["hello\\world", "hello\\world", false],

            // mixing separators
            ["my\\hello/world", "my\\hello\\WORLD", true],
            ["my\\hello/world", "my\\hello\\world", true],
            ["my\\hello/world", "my\\hello\\world", false],
            ["my\\hello/world", "my/hello\\WORLD", true],
            ["my\\hello/world", "my/hello\\world", true],
            ["my\\hello/world", "my/hello\\world", false],
        ];
    }

    /**
     * @dataProvider dataEqualProvider
     */
    public function testEqualComparator($expected, $actual, bool $ignoreCase) {
        $comparator = new DirSeparatorAgnosticStringComparator();
        self::assertTrue($comparator->accepts($expected, $actual));
        $comparator->assertEquals($expected, $actual, 0.0, false, $ignoreCase);
    }

    public function dataComparisonFailure() {
        return [
            ["hello/world", "hello\\WORLD", false],
            ["hello/world", "hello/WORLD", false],
            ["hello\\world", "hello\\WORLD", false],
        ];
    }

    /**
     * @dataProvider dataComparisonFailure
     */
    public function testComparisonFailure($expected, $actual, bool $ignoreCase) {
        self::expectException(ComparisonFailure::class);

        $comparator = new DirSeparatorAgnosticStringComparator();
        self::assertTrue($comparator->accepts($expected, $actual));
        $comparator->assertEquals($expected, $actual, 0.0, false, $ignoreCase);
    }
}