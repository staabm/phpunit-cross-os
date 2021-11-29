<?php

namespace staabm\Tests\PHPUnitCrossOs\Functional;

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\Comparator\ComparisonFailure;
use SebastianBergmann\Comparator\Factory;
use staabm\PHPUnitCrossOs\Comparator\CrossOsAgnosticStringComparator;
use staabm\PHPUnitCrossOs\Comparator\DirSeparatorAgnosticStringComparator;
use staabm\PHPUnitCrossOs\Comparator\EolAgnosticStringComparator;

final class CrossOsAgnosticStringComparatorFunctionalTest extends TestCase {
    /**
     * @var CrossOsAgnosticStringComparator
     */
    private $comparator;

    public function setUp(): void
    {
        $this->comparator = new CrossOsAgnosticStringComparator();

        $factory = Factory::getInstance();
        $factory->register($this->comparator);
    }

    public function tearDown(): void
    {
        $factory = Factory::getInstance();
        $factory->unregister($this->comparator);
    }

    public function dataEqualProvider() {
        return [
            ["hello/world\r\n", "hello\\WORLD\n", true],
            ["hello/world", "hello/WORLD", true],
            ["hello\\world\r\n", "hello\\WORLD\n", true],

            ["hello/world", "hello\\world", true],
            ["hello/world\n", "hello/world\n", true],
            ["hello\\world", "hello\\world", true],
            ["hello/world\n", "hello\\world\r\n", false],
            ["hello/world", "hello/world", false],
            ["hello\\world", "hello\\world", false],
        ];
    }

    /**
     * @dataProvider dataEqualProvider
     */
    public function testAssertSame($expected, $actual, bool $ignoreCase) {
        if ($ignoreCase) {
            self::assertEqualsIgnoringCase($expected, $actual);
        } else {
            self::assertEquals($expected, $actual);
        }
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
        self::expectException(ExpectationFailedException::class);

        if ($ignoreCase) {
            self::assertEqualsIgnoringCase($expected, $actual);
        } else {
            self::assertEquals($expected, $actual);
        }
    }
}