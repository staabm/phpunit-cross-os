<?php

namespace staabm\Tests\PHPUnitCrossOs\Comparator;

use PHPUnit\Framework\TestCase;
use SebastianBergmann\Comparator\ComparisonFailure;
use staabm\PHPUnitCrossOs\Comparator\CrossOsAgnosticComparator;
use staabm\PHPUnitCrossOs\Comparator\CrossOsAgnosticString;
use staabm\PHPUnitCrossOs\Comparator\CrossOsAgnosticStringComparator;
use staabm\PHPUnitCrossOs\Comparator\DirSeparatorAgnosticString;
use staabm\PHPUnitCrossOs\Comparator\DirSeparatorAgnosticStringComparator;
use staabm\PHPUnitCrossOs\Comparator\EolAgnosticString;

final class CrossOsAgnosticComparatorTest extends TestCase {
    public function dataEqualProvider() {
        $eolTest = new EolAgnosticStringComparatorTest();
        $dirSepTest = new DirSeparatorAgnosticStringComparatorTest();

        foreach($eolTest->dataEqualProvider() as $data) {
            [$expected, $actual, $ignoreCase] = $data;
            $expected = new EolAgnosticString($expected);
            yield [$expected, $actual, $ignoreCase];
        }
        foreach($dirSepTest->dataEqualProvider() as $data) {
            [$expected, $actual, $ignoreCase] = $data;
            $expected = new DirSeparatorAgnosticString($expected);
            yield [$expected, $actual, $ignoreCase];
        }

        foreach($eolTest->dataEqualProvider() as $data) {
            [$expected, $actual, $ignoreCase] = $data;
            $expected = new CrossOsAgnosticString($expected);
            yield [$expected, $actual, $ignoreCase];
        }
        foreach($dirSepTest->dataEqualProvider() as $data) {
            [$expected, $actual, $ignoreCase] = $data;
            $expected = new CrossOsAgnosticString($expected);
            yield [$expected, $actual, $ignoreCase];
        }

        yield [new CrossOsAgnosticString("hello\r\nworld/subdir"),"hello\nworld\\subdir", false];
    }

    /**
     * @dataProvider dataEqualProvider
     */
    public function testEqualComparator($expected, $actual, bool $ignoreCase) {
        $comparator = new CrossOsAgnosticComparator();
        self::assertTrue($comparator->accepts($expected, $actual));
        $comparator->assertEquals($expected, $actual, 0.0, false, $ignoreCase);
    }

    public function dataComparisonFailure() {
        $eolTest = new EolAgnosticStringComparatorTest();
        $dirSepTest = new DirSeparatorAgnosticStringComparatorTest();

        foreach([CrossOsAgnosticString::class, EolAgnosticString::class, DirSeparatorAgnosticString::class] as $stringClass) {
            foreach($eolTest->dataComparisonFailure() as $data) {
                [$expected, $actual, $ignoreCase] = $data;
                $expected = new $stringClass($expected);
                yield [$expected, $actual, $ignoreCase];
            }
            foreach($dirSepTest->dataComparisonFailure() as $data) {
                [$expected, $actual, $ignoreCase] = $data;
                $expected = new $stringClass($expected);
                yield [$expected, $actual, $ignoreCase];
            }
        }
    }

    /**
     * @dataProvider dataComparisonFailure
     */
    public function testComparisonFailure($expected, $actual, bool $ignoreCase) {
        self::expectException(ComparisonFailure::class);

        $comparator = new CrossOsAgnosticComparator();
        self::assertTrue($comparator->accepts($expected, $actual));
        $comparator->assertEquals($expected, $actual, 0.0, false, $ignoreCase);
    }
}