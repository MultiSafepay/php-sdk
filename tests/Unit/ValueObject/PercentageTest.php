<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\ValueObject;

use InvalidArgumentException;
use MultiSafepay\ValueObject\Percentage;
use PHPUnit\Framework\TestCase;

/**
 * Class PercentageTest
 * @package MultiSafepay\Tests\Unit\ValueObject
 */
class PercentageTest extends TestCase
{
    /**
     * Test constructing with normal value
     */
    public function testNormalUsage()
    {
        $percentage = new Percentage(42);
        $this->assertEquals(42, $percentage->getValue());
    }

    /**
     * Test constructing with normal value
     */
    public function testZeroPercent()
    {
        $percentage = new Percentage(0);
        $this->assertEquals(0, $percentage->getValue());
    }

    /**
     * Test constructing with normal value
     */
    public function testHundredPercent()
    {
        $percentage = new Percentage(100);
        $this->assertEquals(100, $percentage->getValue());
    }

    /**
     * Test it fails when constructing with negative value
     */
    public function testNegativeNumbers()
    {
        $this->expectException(InvalidArgumentException::class);
        new Percentage(-1);
    }

    /**
     * Test it fails when constructing with value over 100
     */
    public function testUpperBound()
    {
        $this->expectException(InvalidArgumentException::class);
        new Percentage(101);
    }
}
