<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures;

use MultiSafepay\Api\Transactions\RequestOrder\CustomerDetails;
use MultiSafepay\ValueObject\Customer;
use MultiSafepay\ValueObject\Customer\Address;
use MultiSafepay\ValueObject\Customer\EmailAddress;
use MultiSafepay\ValueObject\Customer\IpAddress;

/**
 * Trait CustomerFixture
 * @package MultiSafepay\Tests\Fixtures
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
        $customerDetails = new CustomerDetails('John', 'Doe', $address, $ipAddress, $emailAddress);

        $customerDetails->addLocale('nl');
        $customerDetails->addReferrer('http://example.org');
        $customerDetails->addUserAgent('Unknown');

        return $customerDetails;
    }
}
