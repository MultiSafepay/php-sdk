<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures;

use Money\Money;
use MultiSafepay\Api\Transactions\RequestOrder;
use MultiSafepay\Api\Transactions\RequestOrder\Description;
use MultiSafepay\Api\Transactions\RequestOrder\GatewayInfo;
use MultiSafepay\Api\Transactions\RequestOrder\GoogleAnalytics;
use MultiSafepay\Api\Transactions\RequestOrder\SecondChance;
use MultiSafepay\Api\Transactions\RequestOrderDirect;
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
            $this->createPaymentOptionsFixture(),
            $this->createCustomerDetailsFixture(),
            'ideal',
            new Description('Foobar'),
            new SecondChance(true),
            new GoogleAnalytics('foobar')
        );
    }
}
