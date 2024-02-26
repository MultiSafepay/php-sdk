<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api;

use MultiSafepay\Api\Gateways\Gateway;
use MultiSafepay\Api\Gateways\GatewayListing;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Exception\InvalidDataInitializationException;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class GatewayManager
 * @package MultiSafepay\Api
 */
class GatewayManager extends AbstractManager
{
    public const ALLOWED_OPTIONS = [
        'country' => '',
        'currency' => '',
        'amount' => '',
        'include' => '',
    ];

    /**
     * @param bool $includeCoupons Include coupons (aka giftcards)
     * @return Gateway[]
     * @throws ClientExceptionInterface|InvalidDataInitializationException|ApiException
     */
    public function getGateways(bool $includeCoupons = true): array
    {
        $options = [];
        if ($includeCoupons) {
            $options['include'] = 'coupons';
        }

        $response = $this->client->createGetRequest('json/gateways', $options);
        return (new GatewayListing($response->getResponseData()))->getGateways();
    }

    /**
     * Get all or specific gateway
     * @param string $gatewayCode
     * @param array $options
     * @return Gateway
     * @throws ClientExceptionInterface|InvalidDataInitializationException|ApiException
     */
    public function getByCode(string $gatewayCode, array $options = []): Gateway
    {
        $options = array_intersect_key($options, self::ALLOWED_OPTIONS);

        $endpoint = 'json/gateways/' . $gatewayCode;
        $response = $this->client->createGetRequest($endpoint, $options);

        return new Gateway($response->getResponseData());
    }
}
