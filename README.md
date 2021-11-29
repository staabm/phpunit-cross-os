# PHPUnit Tools to ease cross operating system Testing

## make `assert*` comparisons end-of-line character agnostic

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
    }

}
```