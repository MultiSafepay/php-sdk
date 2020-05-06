<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\RequestOrder\Arguments;

use Faker\Factory as FakerFactory;
use MultiSafepay\Api\Transactions\RequestOrder\Arguments\CustomerDetails;
use MultiSafepay\Tests\Fixtures\ValueObject\AddressFixture;
use MultiSafepay\ValueObject\Customer\EmailAddress;
use MultiSafepay\ValueObject\IpAddress;

/**
 * Trait CustomerFixture
 * @package MultiSafepay\Tests\Fixtures\RequestOrder\Arguments
 */
trait CustomerDetailsFixture
{
    /**
     * @return CustomerDetails
     */
    public function createCustomerDetailsFixture(): CustomerDetails
    {
        $address = $this->createAddressFixture();
        $ipAddress = new IpAddress('10.0.0.1');
        $emailAddress = new EmailAddress('info@example.org');
        $customerDetails = new CustomerDetails('John', 'Doe', $address, $ipAddress, $emailAddress, ['0123456789']);

        $customerDetails->addLocale('nl');
        $customerDetails->addReferrer('http://example.org');
        $customerDetails->addUserAgent('Unknown');

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
        $emailAddress = new EmailAddress($faker->email);
        $customerDetails = new CustomerDetails(
            $faker->firstName,
            $faker->lastName,
            $address,
            $ipAddress,
            $emailAddress,
            [$faker->phoneNumber]
        );

        $customerDetails->addLocale('nl');
        $customerDetails->addReferrer('http://'.$faker->domainName);
        $customerDetails->addUserAgent($faker->userAgent);

        return $customerDetails;
    }
}
