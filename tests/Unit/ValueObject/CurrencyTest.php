<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\ValueObject;

use MultiSafepay\ValueObject\Currency;
use PHPUnit\Framework\TestCase;

class CurrencyTest extends TestCase
{
    /**
     * Test if the currency is set correctly
     *
     * @return void
     */
    public function testIfCurrencyIsSetCorrectly()
    {
        $currency = new Currency('USD');
        $this->assertEquals('USD', $currency->get());
    }
}
