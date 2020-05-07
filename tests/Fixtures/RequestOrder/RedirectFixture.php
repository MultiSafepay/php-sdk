<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\RequestOrder;

use Money\Money;
use MultiSafepay\Api\Gateways\Gateway;
use MultiSafepay\Api\Transactions\RequestOrder\Arguments\Description;
use MultiSafepay\Api\Transactions\RequestOrder\Arguments\Direct\GatewayInfo\Ideal as IdealGatewayInfo;
use MultiSafepay\Api\Transactions\RequestOrder\Redirect as RequestOrderRedirect;

/**
 * Trait RedirectFixture
 * @package MultiSafepay\Tests\Fixtures\RequestOrder
 */
trait RedirectFixture
{
    /**
     * @return RequestOrderRedirect
     */
    public function createIdealOrderRedirectRequestFixture(): RequestOrderRedirect
    {
        return new RequestOrderRedirect(
            (string)time(),
            Money::EUR(20),
            Gateway::IDEAL,
            $this->createPaymentOptionsFixture(),
            new IdealGatewayInfo('0031'),
            new Description('Foobar')
        );
    }
}
