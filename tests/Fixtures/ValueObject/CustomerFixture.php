<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\ValueObject;

use MultiSafepay\ValueObject\Customer;
use MultiSafepay\ValueObject\Customer\EmailAddress;
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
        $address = $this->createAddressFixture();
        $ipAddress = new IpAddress('10.0.0.1');
        $emailAddress = new EmailAddress('info@example.org');
        $customer = new Customer('John', 'Doe', $address, $ipAddress, $emailAddress, ['0123456789']);

        return $customer;
    }
}
