<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\Api\Transactions\OrderRequest\Arguments\TaxTable;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable\TaxRate;
use MultiSafepay\Exception\InvalidArgumentException;
use MultiSafepay\ValueObject\Customer\Country;
use PHPUnit\Framework\TestCase;

/**
 * Class TaxRateTest
 * @package MultiSafepay\Tests\Unit\Api\Transactions\OrderRequest\Arguments
 */
class TaxRateTest extends TestCase
{
    /**
     * Test whether setting the rate works
     */
    public function testAddRateThatWorks()
    {
        $taxRate = new TaxRate();
        $taxRate->addRate(2);
        $this->assertEquals(2, $taxRate->getRate());
    }

    /**
     * Test whether setting the rate works
     */
    public function testAddRateWhichIsInvalidBelowOne()
    {
        $this->expectException(InvalidArgumentException::class);
        $taxRate = new TaxRate();
        $taxRate->addRate(0.1);
    }

    /**
     * Test whether setting the rate works
     */
    public function testAddRateWhichIsInvalidAboveHundred()
    {
        $this->expectException(InvalidArgumentException::class);
        $taxRate = new TaxRate();
        $taxRate->addRate(101);
    }

    /**
     * Test adding a country
     */
    public function testAddCountry()
    {
        $taxRate = new TaxRate();
        $taxRate->addCountry(new Country('NL'));
        $this->assertEquals('NL', $taxRate->getCountry()->getCode());
    }

    /**
     * Test adding a country using the country code
     *
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable\TaxRate::addCountryCode
     */
    public function testAddCountryCode()
    {
        $taxRate = new TaxRate();
        $taxRate->addCountryCode('NL');
        $this->assertEquals('NL', $taxRate->getCountry()->getCode());
    }
}
