<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\OrderRequest;

use Money\Money;
use MultiSafepay\Api\Gateways\Gateway;
use MultiSafepay\Api\Transactions\OrderRequest;

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
        return (new OrderRequest())
            ->addType('direct')
            ->addOrderId((string)time())
            ->addMoney(Money::EUR(20))
            ->addGatewayCode(Gateway::IDEAL)
            ->addGatewayInfo($this->createIdealGatewayInfoFixture())
            ->addPaymentOptions($this->createPaymentOptionsFixture())
            ->addDescription($this->createDescriptionFixture())
            ->addCustomerDetails($this->createCustomerDetailsFixture())
            ->addSecondChance($this->createSecondChanceFixture())
            ->addGoogleAnalytics($this->createRandomGoogleAnalyticsFixture())
            ->addPluginDetails($this->createPluginDetailsFixture());
    }

    /**
     * @return OrderRequest
     */
    public function createRandomOrderIdealDirectRequestFixture(): OrderRequest
    {
        return (new OrderRequest())
            ->addType('direct')
            ->addOrderId((string)time())
            ->addMoney(Money::EUR(20))
            ->addGatewayCode(Gateway::IDEAL)
            ->addGatewayInfo($this->createIdealGatewayInfoFixture())
            ->addPaymentOptions($this->createPaymentOptionsFixture())
            ->addDescription($this->createRandomDescriptionFixture())
            ->addCustomerDetails($this->createCustomerDetailsFixture())
            ->addSecondChance($this->createSecondChanceFixture())
            ->addGoogleAnalytics($this->createRandomGoogleAnalyticsFixture())
            ->addPluginDetails($this->createPluginDetailsFixture());
    }
}
