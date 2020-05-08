<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit\ValueObject;

use MultiSafepay\Tests\Fixtures\ValueObject\AddressFixture;
use MultiSafepay\ValueObject\Customer;
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
        $customer = (new Customer())
            ->addFirstName('John')
            ->addLastName('Doe')
            ->addAddress($address)
            ->addIpAddress($ipAddress)
            ->addEmailAddress($emailAddress)
            ->addPhoneNumber(new Customer\PhoneNumber('0123456789'));

        $this->assertEquals('10.0.0.1', $customer->getIpAddress()->get());
        $this->assertEquals('info@example.org', $customer->getEmailAddress()->get());

        $phoneNumbers = $customer->getPhoneNumbers();
        $this->assertContains('0123456789', $phoneNumbers);
    }
}
