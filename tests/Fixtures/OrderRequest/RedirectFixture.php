<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\OrderRequest;

use MultiSafepay\Api\Transactions\OrderRequest;
use MultiSafepay\Tests\Fixtures\Api\Gateways\GatewayFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\IdealGatewayInfoFixture;
use MultiSafepay\ValueObject\Money;

/**
 * Trait RedirectFixture
 * @package MultiSafepay\Tests\Fixtures\OrderRequest
 */
trait RedirectFixture
{
    use IdealGatewayInfoFixture;

    /**
     * @return OrderRequest
     */
    public function createIdealOrderRedirectRequestFixture(): OrderRequest
    {
        return (new OrderRequest())
            ->addType('redirect')
            ->addOrderId((string)time())
            ->addMoney(new Money(2000, 'EUR'))
            ->addGatewayCode(GatewayFixture::IDEAL)
            ->addGatewayInfo($this->createIdealGatewayInfoFixture())
            ->addPaymentOptions($this->createPaymentOptionsFixture())
            ->addDescription($this->createDescriptionFixture())
            ->addPluginDetails($this->createPluginDetailsFixture());
    }
}
