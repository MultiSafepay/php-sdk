<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\ValueObject;

use MultiSafepay\ValueObject\UnitPrice;
use PHPUnit\Framework\TestCase;

class UnitPriceTest extends TestCase
{
    /**
     * Test if the unit price is set correctly
     *
     * @return void
     */
    public function testIfUnitPriceIsSetCorrectly()
    {
        $unitPrice = new UnitPrice(3.305785124);
        $this->assertEquals(3.305785124, $unitPrice->get());
    }
}
