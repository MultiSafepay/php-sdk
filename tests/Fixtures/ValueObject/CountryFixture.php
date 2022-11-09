<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\ValueObject;

use Faker\Factory as FakerFactory;
use MultiSafepay\ValueObject\Customer\Address;
use MultiSafepay\ValueObject\Customer\Country;

/**
 * Trait CountryFixture
 * @package MultiSafepay\Tests\Fixtures\ValueObject
 */
trait CountryFixture
{
    /**
     * @return string
     */
    public function createCountryCodeFixture(): string
    {
        return 'NL';
    }

    /**
     * @return string
     */
    public function createRandomCountryCodeFixture(): string
    {
        // return $faker->countryCode
        $countryCodes = ['NL'];
        $randomIndex = array_rand($countryCodes);
        return $countryCodes[$randomIndex];
    }
}
