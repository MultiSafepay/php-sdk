<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api;

use InvalidArgumentException;
use MultiSafepay\Api\Issuers\Issuer;
use MultiSafepay\Api\Issuers\IssuerListing;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class IssuerManager
 * @package MultiSafepay\Api
 */
class IssuerManager extends AbstractManager
{
    /**
     * @param string $gatewayCode
     * @return Issuer[]
     * @throws ClientExceptionInterface
     */
    public function getIssuersByGatewayCode(string $gatewayCode): array
    {
        $gatewayCode = strtolower($gatewayCode);
        if (!in_array($gatewayCode, Issuer::ALLOWED_GATEWAY_CODES)) {
            throw new InvalidArgumentException('Gateway code is not allowed');
        }

        $response = $this->client->createGetRequest('issuers/' . $gatewayCode);
        return (new IssuerListing($gatewayCode, $response->getResponseData()))->getIssuers();
    }
}
