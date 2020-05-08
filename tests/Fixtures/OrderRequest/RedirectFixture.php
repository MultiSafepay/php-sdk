<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\OrderRequest;

use Money\Money;
use MultiSafepay\Api\Gateways\Gateway;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\Description;
use MultiSafepay\Api\Transactions\OrderRequest\Redirect as RedirectOrderRequest;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\IdealGatewayInfoFixture;

/**
 * Trait RedirectFixture
 * @package MultiSafepay\Tests\Fixtures\OrderRequest
 */
trait RedirectFixture
{
    use IdealGatewayInfoFixture;

    /**
     * @return RedirectOrderRequest
     */
    public function createIdealOrderRedirectRequestFixture(): RedirectOrderRequest
    {
        return (new RedirectOrderRequest())
            ->addOrderId((string)time())
            ->addMoney(Money::EUR(20))
            ->addGatewayCode(Gateway::IDEAL)
            ->addGatewayInfo($this->createIdealGatewayInfoFixture())
            ->addPaymentOptions($this->createPaymentOptionsFixture())
            ->addDescription($this->createDescriptionFixture())
            ->addPluginDetails($this->createPluginDetailsFixture());
    }
}
