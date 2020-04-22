<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures;

use MultiSafepay\ValueObject\Customer;
use MultiSafepay\ValueObject\Customer\Address;
use MultiSafepay\ValueObject\Customer\EmailAddress;
use MultiSafepay\ValueObject\IpAddress;

/**
 * Trait CustomerFixture
 * @package MultiSafepay\Tests\Fixtures
 */
trait CustomerFixture
{
    /**
     * @return Customer
     */
    public function createCustomerFixture(): Customer
    {
        $address = $this->createAddressFixture();
        $ipAddress = new IpAddress('10.0.0.1');
        $emailAddress = new EmailAddress('info@example.org');
        $customer = new Customer('John', 'Doe', $address, $ipAddress, $emailAddress);

        return $customer;
    }
}
