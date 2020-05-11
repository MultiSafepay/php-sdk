<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\ValueObject;

use Faker\Factory as FakerFactory;
use MultiSafepay\Tests\Utils\Locale;
use MultiSafepay\ValueObject\Customer\PhoneNumber;

/**
 * Trait PhoneNumberFixture
 * @package MultiSafepay\Tests\Fixtures\ValueObject
 */
trait PhoneNumberFixture
{
    /**
     * @return PhoneNumber
     */
    public function createPhoneNumberFixture(): PhoneNumber
    {
        $countryCode = $this->createCountryCodeFixture();
        $faker = FakerFactory::create(Locale::getLocaleByCountryCode($countryCode));
        $phoneNumber = $faker->numberBetween(10000000, 99999999);
        return new PhoneNumber('06' . $phoneNumber);
    }
}
