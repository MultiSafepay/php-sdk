<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\OrderRequest;

use Money\Money;
use MultiSafepay\Api\Gateways\Gateway;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\Description;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\Direct\GatewayInfo\Ideal as IdealGatewayInfo;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PluginDetails;
use MultiSafepay\Api\Transactions\OrderRequest\Redirect as OrderRequestRedirect;

/**
 * Trait RedirectFixture
 * @package MultiSafepay\Tests\Fixtures\OrderRequest
 */
trait RedirectFixture
{
    /**
     * @return OrderRequestRedirect
     */
    public function createIdealOrderRedirectRequestFixture(): OrderRequestRedirect
    {
        $request = new OrderRequestRedirect(
            (string)time(),
            Money::EUR(20),
            Gateway::IDEAL,
            new IdealGatewayInfo('0031'),
            $this->createPaymentOptionsFixture()
        );

        $request->addPluginDetails(new PluginDetails('Foobar', '0.0.1'));
        $request->addDescription(new Description('Foobar'));

        return $request;
    }
}
