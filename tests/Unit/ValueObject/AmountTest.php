<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\ValueObject;

use MultiSafepay\ValueObject\Amount;
use PHPUnit\Framework\TestCase;

class AmountTest extends TestCase
{
    /**
     * Test if the amount is set correctly
     *
     * @return void
     */
    public function testIfAmountIsSetCorrectly()
    {
        $amount = new Amount(100);
        $this->assertEquals(100, $amount->get());
    }
}
