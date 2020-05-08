<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\RequestOrder\Arguments;

use Faker\Factory as FakerFactory;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\CustomerDetails;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\Direct\GatewayInfo\Meta;
use MultiSafepay\ValueObject\BankAccount;
use MultiSafepay\ValueObject\Customer\EmailAddress;
use MultiSafepay\ValueObject\Customer\PhoneNumber;
use MultiSafepay\ValueObject\Date;
use MultiSafepay\ValueObject\Gender;

/**
 * Trait MetaGatewayInfoFixture
 * @package MultiSafepay\Tests\Fixtures\RequestOrder\Arguments
 */
trait MetaGatewayInfoFixture
{
    /**
     * @return CustomerDetails
     */
    public function createMetaGatewayInfoFixture(): Meta
    {
        $faker = FakerFactory::create();

        return new Meta(
            new Date('1970-01-01'),
            new BankAccount($faker->iban()),
            new PhoneNumber($faker->phoneNumber),
            new EmailAddress($faker->email),
            new Gender('male')
        );
    }
}
