<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\OrderRequest\Arguments;

use Faker\Factory as FakerFactory;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Creditcard;
use MultiSafepay\Tests\Utils\Locale;

/**
 * Trait CreditCardGatewayInfoFixture
 * @package MultiSafepay\Tests\Fixtures\OrderRequest\Arguments
 */
trait CreditCardGatewayInfoFixture
{
    /**
     * @return Creditcard
     */
    public function createCreditCardGatewayInfoFixture(): Creditcard
    {
        $countryCode = $this->createCountryCodeFixture();
        $faker = FakerFactory::create(Locale::getLocaleByCountryCode($countryCode));

        return (new Creditcard)
            ->addCardHolderName($faker->name)
            ->addCardNumberAsString('4111111111111111')
            ->addCardExpiryDateAsString($faker->date('Y-m-d', '5 years from now'))
            ->addCvcAsString($faker->numerify('###'));
    }
}
