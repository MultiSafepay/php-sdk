<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\OrderRequest;

use MultiSafepay\ValueObject\Money;
use MultiSafepay\Api\Transactions\OrderRequest;
use MultiSafepay\Tests\Fixtures\Api\Gateways\GatewayFixture;

/**
 * Trait DirectFixture
 * @package MultiSafepay\Tests\Fixtures\OrderRequest
 */
trait DirectFixture
{
    /**
     * @return OrderRequest
     */
    public function createOrderIdealDirectRequestFixture(): OrderRequest
    {
        return $this->createGenericOrderRequestFixture()
            ->addType('direct')
            ->addMoney(new Money(20, 'EUR'))
            ->addGatewayCode(GatewayFixture::IDEAL)
            ->addGatewayInfo($this->createIdealGatewayInfoFixture())
            ->addPaymentOptions($this->createPaymentOptionsFixture())
            ->addSecondChance($this->createSecondChanceFixture())
            ->addGoogleAnalytics($this->createRandomGoogleAnalyticsFixture());
    }

    /**
     * @return OrderRequest
     */
    public function createRandomOrderIdealDirectRequestFixture(): OrderRequest
    {
        return $this->createGenericRandomOrderRequestFixture()
            ->addType('direct')
            ->addMoney(new Money(20, 'EUR'))
            ->addGatewayCode(GatewayFixture::IDEAL)
            ->addGatewayInfo($this->createIdealGatewayInfoFixture())
            ->addPaymentOptions($this->createPaymentOptionsFixture())
            ->addSecondChance($this->createSecondChanceFixture())
            ->addGoogleAnalytics($this->createRandomGoogleAnalyticsFixture());
    }
}
