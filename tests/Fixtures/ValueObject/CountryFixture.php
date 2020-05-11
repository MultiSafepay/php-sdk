<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\ValueObject;

use MultiSafepay\ValueObject\Customer\Address;
use MultiSafepay\ValueObject\Customer\Country;
use Faker\Factory as FakerFactory;

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
     * @todo: How come only NL is allowed by API?
     */
    public function createRandomCountryCodeFixture(): string
    {
        // return $faker->countryCode
        $countryCodes = ['NL'];
        $randomIndex = array_rand($countryCodes);
        return $countryCodes[$randomIndex];
    }
}
