<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\OrderRequest\Arguments;

use MultiSafepay\Sdk;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Ideal;
use MultiSafepay\Tests\Fixtures\Api\Gateways\GatewayFixture;

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
     * @param Sdk $sdk
     * @return Ideal
     */
    public function createRandomIdealGatewayInfoFixture(Sdk $sdk): Ideal
    {
        $issuers = $sdk->getIssuerManager()->getIssuersByGatewayCode(GatewayFixture::IDEAL);
        $randomIndex = array_rand($issuers);
        $randomIssuer = $issuers[$randomIndex];

        return (new Ideal)
            ->addIssuerId((string)$randomIssuer->getCode());
    }
}
