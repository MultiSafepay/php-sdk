<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures;

use Money\Money;
use MultiSafepay\Api\Transactions\RequestOrder\Description;
use MultiSafepay\Api\Transactions\RequestOrder\GatewayInfoIdeal;
use MultiSafepay\Api\Transactions\RequestOrderRedirect;

/**
 * Trait OrderRedirectFixture
 * @package MultiSafepay\Tests\Fixtures
 */
trait OrderRedirectFixture
{
    /**
     * @return RequestOrderRedirect
     */
    public function createOrderRedirectRequestFixture(): RequestOrderRedirect
    {
        return new RequestOrderRedirect(
            (string)time(),
            Money::EUR(20),
            'ideal',
            $this->createPaymentOptionsFixture(),
            new GatewayInfoIdeal('0031'),
            new Description('Foobar')
        );
    }
}
