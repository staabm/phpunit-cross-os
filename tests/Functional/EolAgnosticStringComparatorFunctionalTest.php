<?php

namespace staabm\Tests\PHPUnitCrossOs\Functional;

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\Comparator\ComparisonFailure;
use SebastianBergmann\Comparator\Factory;
use staabm\PHPUnitCrossOs\Comparator\EolAgnosticStringComparator;

final class EolAgnosticStringComparatorFunctionalTest extends TestCase {
    /**
     * @var EolAgnosticStringComparator
     */
    private $comparator;

    public function setUp(): void
    {
        $this->comparator = new EolAgnosticStringComparator();

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
    public function testAssertSame($expected, $actual, bool $ignoreCase) {
        if ($ignoreCase) {
            self::assertEqualsIgnoringCase($expected, $actual);
        } else {
            self::assertEquals($expected, $actual);
        }
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
        self::expectException(ExpectationFailedException::class);

        if ($ignoreCase) {
            self::assertEqualsIgnoringCase($expected, $actual);
        } else {
            self::assertEquals($expected, $actual);
        }
    }
}