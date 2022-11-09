<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\ValueObject;

use MultiSafepay\ValueObject\Money;
use PHPUnit\Framework\TestCase;

/**
 * Class MoneyTest
 * @package MultiSafepay\Tests\Unit\ValueObject
 */
class MoneyTest extends TestCase
{
    /**
     * Test regular usage
     */
    public function testNormalUsage()
    {
        $money = new Money(42);
        $this->assertEquals('EUR', $money->getCurrency());
        $this->assertEquals(42, $money->getAmount());
        $this->assertEquals(4200, $money->getAmountInCents());
        $this->assertEquals('0.4200000000', (string)$money);
    }

    /**
     * Test whether negative() delivers a new object
     */
    public function testNegativeNumbers()
    {
        $money = new Money(-42);
        $this->assertEquals(-42, $money->getAmount());

        $newMoney = $money->negative();
        $this->assertEquals($money->getCurrency(), $newMoney->getCurrency());
        $this->assertEquals(-42, $money->getAmount());
        $this->assertEquals(42, $newMoney->getAmount());
    }
}
