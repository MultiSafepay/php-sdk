<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit\ValueObject;

use MultiSafepay\Tests\Fixtures\AddressFixture;
use MultiSafepay\ValueObject\Customer;
use MultiSafepay\ValueObject\Customer\Address;
use MultiSafepay\ValueObject\Customer\Country;
use MultiSafepay\ValueObject\Customer\EmailAddress;
use MultiSafepay\ValueObject\IpAddress;
use PHPUnit\Framework\TestCase;

/**
 * Class CustomerTest
 * @package MultiSafepay\Tests\Unit\ValueObject
 */
class CustomerTest extends TestCase
{
    use AddressFixture;

    /**
     * Test whether basic values can be set
     */
    public function testAddThings()
    {
        $address = $this->createAddressFixture();
        $ipAddress = new IpAddress('10.0.0.1');
        $emailAddress = new EmailAddress('info@example.org');
        $customer = new Customer('John', 'Doe', $address, $ipAddress, $emailAddress);

        $this->assertEquals('10.0.0.1', $customer->getIpAddress()->get());
        $this->assertEquals('info@example.org', $customer->getEmailAddress()->get());
    }
}
