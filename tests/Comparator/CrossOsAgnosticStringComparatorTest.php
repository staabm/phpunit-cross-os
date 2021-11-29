<?php

namespace staabm\Tests\PHPUnitCrossOs\Comparator;

use PHPUnit\Framework\TestCase;
use SebastianBergmann\Comparator\ComparisonFailure;
use staabm\PHPUnitCrossOs\Comparator\CrossOsAgnosticStringComparator;
use staabm\PHPUnitCrossOs\Comparator\DirSeparatorAgnosticStringComparator;

final class CrossOsAgnosticStringComparatorTest extends TestCase {
    public function dataEqualProvider() {
        $eolTest = new EolAgnosticStringComparatorTest();
        $dirSepTest = new DirSeparatorAgnosticStringComparatorTest();

        yield from $eolTest->dataEqualProvider();
        yield from $dirSepTest->dataEqualProvider();

        yield ["hello\r\nworld/subdir","hello\nworld\\subdir", false];
    }

    /**
     * @dataProvider dataEqualProvider
     */
    public function testEqualComparator($expected, $actual, bool $ignoreCase) {
        $comparator = new CrossOsAgnosticStringComparator();
        self::assertTrue($comparator->accepts($expected, $actual));
        $comparator->assertEquals($expected, $actual, 0.0, false, $ignoreCase);
    }

    public function dataComparisonFailure() {
        $eolTest = new EolAgnosticStringComparatorTest();
        $dirSepTest = new DirSeparatorAgnosticStringComparatorTest();

        yield from $eolTest->dataComparisonFailure();
        yield from $dirSepTest->dataComparisonFailure();
    }

    /**
     * @dataProvider dataComparisonFailure
     */
    public function testComparisonFailure($expected, $actual, bool $ignoreCase) {
        self::expectException(ComparisonFailure::class);

        $comparator = new CrossOsAgnosticStringComparator();
        self::assertTrue($comparator->accepts($expected, $actual));
        $comparator->assertEquals($expected, $actual, 0.0, false, $ignoreCase);
    }
}