<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\ValueObject;

use Faker\Factory as FakerFactory;
use MultiSafepay\ValueObject\Customer;
use MultiSafepay\ValueObject\Customer\EmailAddress;
use MultiSafepay\ValueObject\Customer\PhoneNumber;
use MultiSafepay\ValueObject\IpAddress;

/**
 * Trait CustomerFixture
 * @package MultiSafepay\Tests\Fixtures\ValueObject
 */
trait CustomerFixture
{
    use AddressFixture;

    /**
     * @return Customer
     */
    public function createCustomerFixture(): Customer
    {
        $customer = (new Customer())
            ->addFirstName('John')
            ->addLastName('Doe')
            ->addAddress($this->createAddressFixture())
            ->addIpAddress(new IpAddress('10.0.0.1'))
            ->addEmailAddress(new EmailAddress('info@example.org'))
            ->addPhoneNumber(new PhoneNumber('0123456789'));

        return $customer;
    }

    /**
     * @return Customer
     */
    public function createRandomCustomerFixture(): Customer
    {
        $faker = FakerFactory::create();
        $customer = (new Customer())
            ->addFirstName($faker->firstName)
            ->addLastName($faker->lastName)
            ->addAddress($this->createAddressFixture())
            ->addIpAddress(new IpAddress($faker->ipv4))
            ->addEmailAddress(new EmailAddress($faker->freeEmail))
            ->addPhoneNumber(new PhoneNumber($faker->phoneNumber))
            ->addPhoneNumber(new PhoneNumber($faker->phoneNumber));

        return $customer;
    }
}
