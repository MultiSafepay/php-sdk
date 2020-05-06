<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\ValueObject;

use MultiSafepay\ValueObject\Customer\Address;
use MultiSafepay\ValueObject\Customer\Country;

/**
 * Trait AddressFixture
 * @package MultiSafepay\Tests\Fixtures\ValueObject
 */
trait AddressFixture
{
    /**
     * @return Address
     */
    public function createAddressFixture(): Address
    {
        $country = new Country('NL', 'Nederland');
        return new Address(
            'Kraanspoor',
            '(blue door)',
            '18',
            'A',
            '1000AA',
            'Amsterdam',
            'Noord Holland',
            $country
        );
    }
}
