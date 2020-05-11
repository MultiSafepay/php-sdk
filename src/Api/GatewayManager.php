<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api;

use MultiSafepay\Api\Gateways\Gateway;
use MultiSafepay\Api\Gateways\GatewayListing;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class GatewayManager
 * @package MultiSafepay\Api
 */
class GatewayManager extends AbstractManager
{
    const ALLOWED_OPTIONS = [
        'country' => '',
        'currency' => '',
        'amount' => '',
        'include' => ''
    ];

    /**
     * @param bool $includeCoupons Include coupons (aka giftcards)
     * @return Gateway[]
     * @throws ClientExceptionInterface
     */
    public function getGateways(bool $includeCoupons = false): array
    {
        $options = [];
        if ($includeCoupons) {
            $options['include'] = 'coupons';
        }

        $response = $this->client->createGetRequest('gateways', $options);
        return (new GatewayListing($response->getResponseData()))->getGateways();
    }

    /**
     * Get all or specific gateway
     * @param string $gatewayCode
     * @param array $options
     * @return Gateway
     * @throws ClientExceptionInterface
     */
    public function getByCode(string $gatewayCode, array $options = []): Gateway
    {
        $options = array_intersect_key(self::ALLOWED_OPTIONS, $options);

        $endpoint = 'gateways/' . $gatewayCode;
        $response = $this->client->createGetRequest($endpoint, $options);

        return new Gateway($response->getResponseData());
    }
}
