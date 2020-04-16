<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit\ValueObject;

use MultiSafepay\ValueObject\Customer;
use MultiSafepay\ValueObject\Customer\Address;
use MultiSafepay\ValueObject\Customer\Country;
use MultiSafepay\ValueObject\Customer\EmailAddress;
use MultiSafepay\ValueObject\Customer\IpAddress;
use PHPUnit\Framework\TestCase;

/**
 * Class CustomerTest
 * @package MultiSafepay\Tests\Unit\ValueObject
 */
class CustomerTest extends TestCase
{
    /**
     * Test whether basic values can be set
     */
    public function testAddThings()
    {
        $country = new Country('NL', 'Nederland');
        $address = new Address(
            'Kraanspoor',
            '',
            '18',
            '',
            '1000AA',
            'Amsterdam',
            'Noord Holland',
            $country,
            ['0123456789']
        );
        $ipAddress = new IpAddress('10.0.0.1');
        $emailAddress = new EmailAddress('info@example.org');

        $customer = new Customer('John', 'Doe', $address, $ipAddress, $emailAddress);

        $this->assertEquals('10.0.0.1', $customer->getIpAddress()->get());
        $this->assertEquals('info@example.org', $customer->getEmailAddress()->get());
    }
}
