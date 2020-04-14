<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api;

use Psr\Http\Client\ClientExceptionInterface;

class Gateways extends Base
{
    const ALLOWED_OPTIONS = [
        'country' => '',
        'currency' => '',
        'amount' => '',
        'include' => ''
    ];

    /**
     * @return array
     * @throws ClientExceptionInterface
     * @todo Convert response into an array of Gateway Value Objects
     */
    public function getAll(): array
    {
        $response = $this->client->createGetRequest('gateways');
        return $response->getResponseData();
    }

    /**
     * Get all or specific gateway
     * @param string $gatewayCode
     * @param array $options
     * @return array
     * @throws ClientExceptionInterface
     * @todo Convert response into a Gateway Value Object
     */
    public function getByCode(string $gatewayCode, array $options = []): array
    {
        $options = array_intersect_key(self::ALLOWED_OPTIONS, $options);

        $endpoint = 'gateways/' . $gatewayCode;
        $response = $this->client->createGetRequest($endpoint, $options);

        return $response->getResponseData();
    }
}
