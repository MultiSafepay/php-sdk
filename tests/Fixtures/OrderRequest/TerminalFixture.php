<?php declare(strict_types=1);
/**
 * Copyright © 2023 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\OrderRequest;

use MultiSafepay\Api\Transactions\OrderRequest;
use MultiSafepay\Tests\Fixtures\Api\Gateways\GatewayFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\TerminalGatewayInfoFixture;
use MultiSafepay\ValueObject\Money;

/**
 * Trait TerminalFixture
 * @package MultiSafepay\Tests\Fixtures\OrderRequest
 */
trait TerminalFixture
{
    use TerminalGatewayInfoFixture;

    /**
     * @return OrderRequest
     */
    public function createTerminalOrderRedirectRequestFixture(): OrderRequest
    {
        return (new OrderRequest())
            ->addType('redirect')
            ->addOrderId((string)time())
            ->addMoney(new Money(2000, 'EUR'))
            ->addGatewayCode(GatewayFixture::IDEAL)
            ->addGatewayInfo($this->createTerminalGatewayInfoFixture())
            ->addPaymentOptions($this->createPaymentOptionsFixture())
            ->addDescription($this->createDescriptionFixture())
            ->addPluginDetails($this->createPluginDetailsFixture());
    }
}
