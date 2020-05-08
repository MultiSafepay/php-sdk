<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\OrderRequest\Arguments;

use Faker\Factory as FakerFactory;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Meta;
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
        $faker = FakerFactory::create();
        return (new Meta)
            ->addBirthday(new Date($faker->date()))
            ->addEmailAddress(new EmailAddress($faker->email))
            ->addBankAccount(new BankAccount($faker->bankAccountNumber))
            ->addPhone(new PhoneNumber($faker->phoneNumber))
            ->addGender(new Gender('male'));
    }
}
