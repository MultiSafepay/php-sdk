<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\RequestOrder;

use Money\Money;
use MultiSafepay\Api\Transactions\RequestOrder\Arguments\Description;
use MultiSafepay\Api\Transactions\RequestOrder\Arguments\Direct\GatewayInfo\Ideal as IdealGatewayInfo;
use MultiSafepay\Api\Transactions\RequestOrder\Arguments\GoogleAnalytics;
use MultiSafepay\Api\Transactions\RequestOrder\Arguments\SecondChance;
use MultiSafepay\Api\Transactions\RequestOrder\Direct as RequestOrderDirect;

/**
 * Trait DirectFixture
 * @package MultiSafepay\Tests\Fixtures\RequestOrder
 */
trait DirectFixture
{
    /**
     * @return RequestOrderDirect
     */
    public function createOrderIdealDirectRequestFixture(): RequestOrderDirect
    {
        return new RequestOrderDirect(
            (string)time(),
            Money::EUR(20),
            $this->createPaymentOptionsFixture(),
            $this->createCustomerDetailsFixture(),
            null,
            'IDEAL',
            new IdealGatewayInfo('0021'),
            new Description('Foobar'),
            new SecondChance(true),
            new GoogleAnalytics('foobar')
        );
    }
}
