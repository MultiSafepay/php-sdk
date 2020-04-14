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
     * @param bool $includeCoupons
     * @return array
     * @throws ClientExceptionInterface
     * @todo Convert response into an array of Gateway Value Objects
     * @todo Add a new field `type` and method `getType()` to the Gateway Value Object
     */
    public function getAll(bool $includeCoupons = false): array
    {
        $options = [];
        if ($includeCoupons) {
            $options['include'] = 'coupons';
        }

        $response = $this->client->createGetRequest('gateways', $options);
        return $response->getResponseData();
    }

    /**
     * Get all or specific gateway
     * @param string|null $gatewayCode
     * @param array $options
     * @return array
     * @throws ClientExceptionInterface
     * @todo Convert response into a Gateway Value Object
     */
    public function getByCode(?string $gatewayCode = null, array $options = []): array
    {
        $options = array_intersect_key(self::ALLOWED_OPTIONS, $options);

        $endpoint = 'gateways/' . $gatewayCode;
        $response = $this->client->createGetRequest($endpoint, $options);

        return $response->getResponseData();
    }
}
