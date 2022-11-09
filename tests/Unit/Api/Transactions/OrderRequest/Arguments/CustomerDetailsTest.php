<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\Api\Transactions\OrderRequest\Arguments;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\CustomerDetails;
use MultiSafepay\Tests\Fixtures\ValueObject\AddressFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\CountryFixture;
use MultiSafepay\ValueObject\Customer\EmailAddress;
use MultiSafepay\ValueObject\Customer\PhoneNumber;
use MultiSafepay\ValueObject\IpAddress;
use PHPUnit\Framework\TestCase;

/**
 * Class CustomerDetailsTest
 * @package MultiSafepay\Tests\Unit\Api\Transactions\OrderRequest\Arguments
 */
class CustomerDetailsTest extends TestCase
{
    use AddressFixture;
    use CountryFixture;

    /**
     * Test case to guarantee that CustomerDetails transfers all details properly
     */
    public function testWorkingCustomerDetails()
    {
        $customerDetails = (new CustomerDetails())
            ->addFirstName('John')
            ->addLastName('Doe')
            ->addAddress($this->createAddressFixture())
            ->addIpAddress(new IpAddress('127.0.0.1'))
            ->addEmailAddress(new EmailAddress('info@example.org'))
            ->addPhoneNumber(new PhoneNumber('0123456789'))
            ->addLocale('nl_NL')
            ->addReferrer('http://example.org')
            ->addUserAgent('Unknown');

        $this->assertEquals('John', $customerDetails->getFirstName());
        $this->assertEquals('nl_NL', $customerDetails->getLocale());
        $this->assertEquals('http://example.org', $customerDetails->getReferrer());
        $this->assertEquals('Unknown', $customerDetails->getUserAgent());

        $customerData = $customerDetails->getData();
        $this->assertEquals('Kraanspoor', $customerData['address1']);
        $this->assertEquals('(blue door)', $customerData['address2']);
        $this->assertEquals('39', $customerData['house_number']);
        $this->assertEquals('1033SC', $customerData['zip_code']);
        $this->assertEquals('Amsterdam', $customerData['city']);
        $this->assertEquals('Noord Holland', $customerData['state']);
        $this->assertEquals('NL', $customerData['country']);
        $this->assertEquals('0123456789', $customerData['phone']);
        $this->assertEquals('info@example.org', $customerData['email']);
        $this->assertEquals('127.0.0.1', $customerData['ip_address']);
        $this->assertEquals('nl_NL', $customerData['locale']);
        $this->assertEquals('http://example.org', $customerData['referrer']);
        $this->assertEquals('Unknown', $customerData['user_agent']);
    }

    /**
     * Test if forwardedIp can be set using the AsString function
     *
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\CustomerDetails::addForwardedIpAsString
     */
    public function testForwardedIpBeingSetWithAsStringFunction()
    {
        $customerDetails = (new CustomerDetails())
            ->addForwardedIpAsString('10.0.0.1');

        $this->assertEquals('10.0.0.1', $customerDetails->getForwardedIp()->get());
    }
}
