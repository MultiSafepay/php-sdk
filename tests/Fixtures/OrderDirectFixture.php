<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures;

use Money\Money;
use MultiSafepay\Api\Transactions\RequestOrder\Description;
use MultiSafepay\Api\Transactions\RequestOrder\GatewayInfoIdeal;
use MultiSafepay\Api\Transactions\RequestOrder\GoogleAnalytics;
use MultiSafepay\Api\Transactions\RequestOrder\SecondChance;
use MultiSafepay\Api\Transactions\RequestOrderDirect;

/**
 * Trait OrderDirectFixture
 * @package MultiSafepay\Tests\Fixtures
 */
trait OrderDirectFixture
{
    /**
     * @return RequestOrderDirect
     */
    public function createOrderDirectRequestFixture(): RequestOrderDirect
    {
        return new RequestOrderDirect(
            (string)time(),
            Money::EUR(20),
            $this->createPaymentOptionsFixture(),
            $this->createCustomerDetailsFixture(),
            null,
            'IDEAL',
            new GatewayInfoIdeal('0021'),
            new Description('Foobar'),
            new SecondChance(true),
            new GoogleAnalytics('foobar')
        );
    }
}
