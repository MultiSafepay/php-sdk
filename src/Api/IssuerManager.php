<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api;

use InvalidArgumentException;
use MultiSafepay\Api\Issuers\Issuer;
use MultiSafepay\Api\Issuers\Issuers;
use Psr\Http\Client\ClientExceptionInterface;

class IssuerManager extends Base
{
    /**
     * @return Issuers
     * @throws ClientExceptionInterface
     */
    public function getIssuersByGatewayCode(string $gatewayCode): Issuers
    {
        $gatewayCode = strtolower($gatewayCode);
        if (!in_array($gatewayCode, Issuer::ALLOWED_GATEWAY_CODES)) {
            throw new InvalidArgumentException('Gateway code is not allowed');
        }

        $response = $this->client->createGetRequest('gateways');
        return new Issuers($gatewayCode, $response->getResponseData());
    }
}
