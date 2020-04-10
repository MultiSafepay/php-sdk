<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api;

use MultiSafepay\Api\Gateways\Gateways as GatewaysResult;
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
     * Get all or specific gateway
     * @param string|null $gatewayCode
     * @param array $options
     * @return GatewaysResult
     * @throws ClientExceptionInterface
     */
    public function get(?string $gatewayCode = null, array $options = []): GatewaysResult
    {
        $options = array_intersect_key(self::ALLOWED_OPTIONS, $options);

        $endpoint = 'gateways/' . $gatewayCode;
        $response = $this->client->createGetRequest($endpoint, $options);

        return new GatewaysResult($response);
    }
}
