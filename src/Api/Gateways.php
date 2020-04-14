<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api;

use MultiSafepay\Api\Gateways\Gateway;
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
     * @return Gateways
     * @throws ClientExceptionInterface
     */
    public function getGateways(): Gateways\Gateways
    {
        $response = $this->client->createGetRequest('gateways');
        return new Gateways\Gateways($response->getResponseData());
    }

    /**
     * Get all or specific gateway
     * @param string|null $gatewayCode
     * @param array $options
     * @return Gateway
     * @throws ClientExceptionInterface
     */
    public function getByCode(?string $gatewayCode = null, array $options = []): Gateway
    {
        $options = array_intersect_key(self::ALLOWED_OPTIONS, $options);

        $endpoint = 'gateways/' . $gatewayCode;
        $response = $this->client->createGetRequest($endpoint, $options);

        return new Gateway($response->getResponseData());
    }
}
