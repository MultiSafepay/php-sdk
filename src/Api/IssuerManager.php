<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api;

use MultiSafepay\Api\Issuers\Issuer;
use MultiSafepay\Api\Issuers\IssuerListing;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Exception\InvalidArgumentException;
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
     * @throws ClientExceptionInterface|InvalidArgumentException|ApiException
     */
    public function getIssuersByGatewayCode(string $gatewayCode): array
    {
        $gatewayCode = strtolower($gatewayCode);
        if (!in_array($gatewayCode, Issuer::ALLOWED_GATEWAY_CODES)) {
            throw new InvalidArgumentException('Gateway code is not allowed');
        }

        $response = $this->client->createGetRequest('json/issuers/' . $gatewayCode);
        return (new IssuerListing($gatewayCode, $response->getResponseData()))->getIssuers();
    }
}
