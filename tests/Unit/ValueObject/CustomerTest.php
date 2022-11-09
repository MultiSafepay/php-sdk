<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\ValueObject;

use MultiSafepay\Tests\Fixtures\ValueObject\AddressFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\CountryFixture;
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
    use CountryFixture;

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
            ->addCompanyName('MultiSafepay')
            ->addAddress($address)
            ->addIpAddress($ipAddress)
            ->addEmailAddress($emailAddress)
            ->addPhoneNumber(new Customer\PhoneNumber('0123456789'));
        
        $this->assertEquals('MultiSafepay', $customer->getCompanyName());
        $this->assertEquals('10.0.0.1', $customer->getIpAddress()->get());
        $this->assertEquals('info@example.org', $customer->getEmailAddress()->get());
        $this->assertEquals('0123456789', $customer->getPhoneNumber()->get());
    }

    /**
     * Test whether value objects can be set using their AsString functions
     */
    public function testAddValueObjectsAsString()
    {

        $customer = (new Customer())
            ->addIpAddressAsString('10.0.0.1')
            ->addEmailAddressAsString('info@example.org')
            ->addPhoneNumberAsString('0123456789');

        $this->assertEquals('10.0.0.1', $customer->getIpAddress()->get());
        $this->assertEquals('info@example.org', $customer->getEmailAddress()->get());
        $this->assertEquals('0123456789', $customer->getPhoneNumber()->get());
    }
}
