<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\OrderRequest\Arguments;

use Faker\Factory as FakerFactory;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Meta;
use MultiSafepay\Tests\Utils\Locale;
use MultiSafepay\ValueObject\BankAccount;
use MultiSafepay\ValueObject\Customer\EmailAddress;
use MultiSafepay\ValueObject\Customer\PhoneNumber;
use MultiSafepay\ValueObject\Date;
use MultiSafepay\ValueObject\Gender;

/**
 * Trait MetaGatewayInfoFixture
 * @package MultiSafepay\Tests\Fixtures\OrderRequest\Arguments
 */
trait MetaGatewayInfoFixture
{
    /**
     * @return Meta
     */
    public function createRandomMetaGatewayInfoFixture(): Meta
    {
        $countryCode = $this->createCountryCodeFixture();
        $faker = FakerFactory::create(Locale::getLocaleByCountryCode($countryCode));

        return (new Meta)
            ->addBirthday(new Date($faker->date('Y-m-d', '20 years ago')))
            ->addEmailAddress(new EmailAddress($faker->freeEmail))
            ->addBankAccount(new BankAccount($faker->bankAccountNumber))
            ->addPhone($this->createPhoneNumberFixture())
            ->addGender(new Gender('male'))
            ->addData(['something' => 'else']);
    }
}
