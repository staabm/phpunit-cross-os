# PHPUnit Tools to ease cross operating system Testing

## make `assertEquals*` comparisons end-of-line (aka `PHP_EOL`) character agnostic

Make use of [`EolAgnosticStringComparator`](https://github.com/staabm/phpunit-cross-os/blob/main/lib/Comparator/EolAgnosticStringComparator.php) to make your regular `assert*`-calls succeed even if the compared string differ in end-of-line characters: 

```php
final class MyTestCase extends TestCase {

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

    public function testStringsAreEqual() {
        // this assertion will be considered successfull
        self::assertEquals("hello\nworld", "hello\r\nworld");
        // works also for assertEquals* variants
        self::assertEqualsIgnoringCase("hello\nworld", "hello\r\nWORLD");
    }

}
```

## make `assertEquals*` comparisons directory-separator (aka `DIRECTORY_SEPARATOR`) character agnostic

Make use of [`DirSeparatorAgnosticStringComparator.php`](https://github.com/staabm/phpunit-cross-os/blob/main/lib/Comparator/DirSeparatorAgnosticStringComparator.php.php) to make your regular `assert*`-calls succeed even if the compared string differ in directory-separation characters: 

```php
final class MyTestCase extends TestCase {

    /**
     * @var DirSeparatorAgnosticStringComparator
     */
    private $comparator;

    public function setUp(): void
    {
        $this->comparator = new DirSeparatorAgnosticStringComparator();

        $factory = Factory::getInstance();
        $factory->register($this->comparator);
    }

    public function tearDown(): void
    {
        $factory = Factory::getInstance();
        $factory->unregister($this->comparator);
    }

    public function testStringsAreEqual() {
        // this assertion will be considered successfull
        self::assertEquals("hello\\world", "hello/world");
        // works also for assertEquals* variants
        self::assertEqualsIgnoringCase("hello\\world", "hello/WORLD");
    }

}
```


## make `assertEquals*` comparisons cross os agnostic

Make use of [`CrossOsAgnosticStringComparatorFunctionalTest.php`](https://github.com/staabm/phpunit-cross-os/blob/main/lib/Comparator/CrossOsAgnosticStringComparatorFunctionalTest.php.php) to make your regular `assert*`-calls succeed even if the compared string differ in directory-separation and/or end-of-line characters:

`CrossOsAgnosticStringComparatorFunctionalTest` essentially provides all features of `DirSeparatorAgnosticStringComparator` and `EolAgnosticStringComparator` combined in a single class.

```php
use SebastianBergmann\Comparator\Factory;
use staabm\PHPUnitCrossOs\Comparator\CrossOsAgnosticStringComparatorFunctionalTest;

final class MyTestCase extends TestCase {

    /**
     * @var CrossOsAgnosticStringComparatorFunctionalTest
     */
    private $comparator;

    public function setUp(): void
    {
        $this->comparator = new CrossOsAgnosticStringComparatorFunctionalTest();

        $factory = Factory::getInstance();
        $factory->register($this->comparator);
    }

    public function tearDown(): void
    {
        $factory = Factory::getInstance();
        $factory->unregister($this->comparator);
    }

    public function testStringsAreEqual() {
        // this assertion will be considered successfull
        self::assertEquals("hello\\world\n", "hello/world\r\n");
        // works also for assertEquals* variants
        self::assertEqualsIgnoringCase("hello\\world\r\n", "hello/WORLD\n");
    }

}
```