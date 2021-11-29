<?php

namespace staabm\Tests\PHPUnitCrossOs\Comparator;

use PHPUnit\Framework\TestCase;
use SebastianBergmann\Comparator\ComparisonFailure;
use staabm\PHPUnitCrossOs\Comparator\EolAgnosticStringComparator;

final class EolAgnosticStringComparatorTest extends TestCase {
    public function dataEqualProvider() {
        return [
            ["hello\nworld", "hello\r\nWORLD", true],
            ["hello\nworld", "hello\nWORLD", true],
            ["hello\r\nworld", "hello\r\nWORLD", true],

            ["hello\nworld", "hello\r\nworld", true],
            ["hello\nworld", "hello\nworld", true],
            ["hello\r\nworld", "hello\r\nworld", true],
            ["hello\nworld", "hello\r\nworld", false],
            ["hello\nworld", "hello\nworld", false],
            ["hello\r\nworld", "hello\r\nworld", false],
        ];
    }

    /**
     * @dataProvider dataEqualProvider
     */
    public function testEqualComparator($expected, $actual, bool $ignoreCase) {
        $comparator = new EolAgnosticStringComparator();
        self::assertTrue($comparator->accepts($expected, $actual));
        $comparator->assertEquals($expected, $actual, 0.0, false, $ignoreCase);
    }

    public function dataComparisonFailure() {
        return [
            ["hello\nworld", "hello\r\nWORLD", false],
            ["hello\nworld", "hello\nWORLD", false],
            ["hello\r\nworld", "hello\r\nWORLD", false],
        ];
    }

    /**
     * @dataProvider dataComparisonFailure
     */
    public function testComparisonFailure($expected, $actual, bool $ignoreCase) {
        self::expectException(ComparisonFailure::class);

        $comparator = new EolAgnosticStringComparator();
        self::assertTrue($comparator->accepts($expected, $actual));
        $comparator->assertEquals($expected, $actual, 0.0, false, $ignoreCase);
    }
}