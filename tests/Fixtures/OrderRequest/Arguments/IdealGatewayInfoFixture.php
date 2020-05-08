<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\OrderRequest\Arguments;

use MultiSafepay\Api;
use MultiSafepay\Api\Gateways\Gateway;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Ideal;

/**
 * Trait IdealGatewayInfoFixture
 * @package MultiSafepay\Tests\Fixtures\OrderRequest\Arguments
 */
trait IdealGatewayInfoFixture
{
    /**
     * @return Ideal
     */
    public function createIdealGatewayInfoFixture(): Ideal
    {
        return (new Ideal)
            ->addIssuerId('0031');
    }

    /**
     * @param Api $api
     * @return Ideal
     */
    public function createRandomIdealGatewayInfoFixture(Api $api): Ideal
    {
        $issuers = $api->getIssuerManager()->getIssuersByGatewayCode(Gateway::IDEAL);
        print_r($issuers);exit;

        return (new Ideal)
            ->addIssuerId('0031');
    }
}
