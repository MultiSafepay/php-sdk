<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\OrderRequest\Arguments;

use Faker\Factory as FakerFactory;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\CustomerDetails;
use MultiSafepay\ValueObject\Customer\EmailAddress;
use MultiSafepay\ValueObject\Customer\PhoneNumber;
use MultiSafepay\ValueObject\IpAddress;

/**
 * Trait CustomerFixture
 * @package MultiSafepay\Tests\Fixtures\OrderRequest\Arguments
 */
trait CustomerDetailsFixture
{
    /**
     * @return CustomerDetails
     */
    public function createCustomerDetailsFixture(): CustomerDetails
    {
        $customerDetails = (new CustomerDetails())
            ->addFirstName('John')
            ->addLastName('Doe')
            ->addAddress($this->createAddressFixture())
            ->addIpAddress(new IpAddress('10.0.0.1'))
            ->addEmailAddress(new EmailAddress('info@example.org'))
            ->addPhoneNumber(new PhoneNumber('0612345678'))
            ->addLocale('nl')
            ->addReferrer('http://example.org')
            ->addData(['something' => 'else'])
            ->addUserAgent('Unknown');

        return $customerDetails;
    }

    /**
     * @return CustomerDetails
     */
    public function createRandomCustomerDetailsFixture(): CustomerDetails
    {
        $faker = FakerFactory::create();

        $address = $this->createRandomAddressFixture();
        $ipAddress = new IpAddress($faker->ipv4);
        $emailAddress = new EmailAddress($faker->freeEmail);

        $customerDetails = (new CustomerDetails())
            ->addFirstName($faker->firstName)
            ->addLastName($faker->lastName)
            ->addAddress($address)
            ->addIpAddress($ipAddress)
            ->addEmailAddress($emailAddress)
            ->addPhoneNumber($this->createPhoneNumberFixture())
            ->addPhoneNumber($this->createPhoneNumberFixture())
            ->addLocale('nl')
            ->addReferrer($faker->url)
            ->addUserAgent($faker->userAgent);

        return $customerDetails;
    }
}
