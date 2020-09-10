<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit\ValueObject\Customer;

use MultiSafepay\ValueObject\Customer\Address;
use MultiSafepay\ValueObject\Customer\Country;
use PHPUnit\Framework\TestCase;

/**
 * Class AddressTest
 * @package MultiSafepay\Tests\Unit\ValueObject\Customer
 */
class AddressTest extends TestCase
{
    /**
     * Test whether a value could be set and used
     */
    public function testWhetherValueCanBeSetAndUsed()
    {
        $country = new Country('NL');
        $address = (new Address())
            ->addStreetName('Kraanspoor')
            ->addHouseNumber('18')
            ->addStreetNameAdditional('')
            ->addZipCode('1000AA')
            ->addCity('Amsterdam')
            ->addState('Noord Holland')
            ->addCountry($country);


        $this->assertEquals('Kraanspoor', $address->getStreetName());
        $this->assertEquals('18', $address->getHouseNumber());
        $this->assertEmpty($address->getStreetNameAdditional());
        $this->assertEmpty($address->getHouseNumberSuffix());

        $this->assertEquals('1000AA', $address->getZipCode());
        $this->assertEquals('Amsterdam', $address->getCity());
        $this->assertEquals('Noord Holland', $address->getState());

        $country = $address->getCountry();
        $this->assertEquals('NL', $country->getCode());
    }
}
