<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit\ValueObject\Customer;

use MultiSafepay\ValueObject\Customer\Country;
use PHPUnit\Framework\TestCase;

/**
 * Class CountryTest
 * @package MultiSafepay\Tests\Unit\ValueObject\Customer
 */
class CountryTest extends TestCase
{
    /**
     * Test whether a value could be set and used
     */
    public function testWhetherValueCanBeSetAndUsed()
    {
        $country = new Country('nl', 'Nederland');
        $this->assertEquals('NL', $country->getCode());
        $this->assertEquals('Nederland', $country->getName());
    }
}
