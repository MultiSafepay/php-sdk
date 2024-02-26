<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api;

use MultiSafepay\Api\Base\Response;
use MultiSafepay\Api\PaymentMethods\PaymentMethod;
use MultiSafepay\Api\PaymentMethods\PaymentMethodListing;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Exception\InvalidDataInitializationException;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class PaymentMethodsManager
 * @package MultiSafepay\Api
 */
class PaymentMethodManager extends AbstractManager
{
    public const ALLOWED_OPTIONS = [
        'country' => '',
        'currency' => '',
        'amount' => '',
        'locale' => '',
        'group_cards' => '',
        'include_coupons' => '',
    ];

    /**
     * Get payment methods request
     *
     * @param bool $includeCoupons
     * @param array $options
     * @return Response
     * @throws ClientExceptionInterface|ApiException
     */
    private function getPaymentMethodsRequest(bool $includeCoupons = true, array $options = []): Response
    {
        $options = array_intersect_key($options, self::ALLOWED_OPTIONS);
        if ($includeCoupons) {
            $options['include_coupons'] = '1';
        }

        return $this->client->createGetRequest('json/payment-methods', $options);
    }

    /**
     * Get all the payment methods
     *
     * @param bool $includeCoupons
     * @param array $options
     * @return array
     * @throws ClientExceptionInterface|InvalidDataInitializationException|ApiException
     */
    public function getPaymentMethods(bool $includeCoupons = true, array $options = []): array
    {
        $response = $this->getPaymentMethodsRequest($includeCoupons, $options);
        return (new PaymentMethodListing($response->getResponseData()))->getPaymentMethods();
    }

    /**
     * Get all the payment methods as array
     *
     * @param array $options
     * @param bool $includeCoupons
     * @return array
     * @throws ClientExceptionInterface|InvalidDataInitializationException|ApiException
     */
    public function getPaymentMethodsAsArray(bool $includeCoupons = true, array $options = []): array
    {
        $response = $this->getPaymentMethodsRequest($includeCoupons, $options);
        return (new PaymentMethodListing($response->getResponseData()))->asArray();
    }

    /**
     * Get specific payment methods
     *
     * @param string $gatewayCode
     * @param array $options
     * @return PaymentMethod
     * @throws ClientExceptionInterface|InvalidDataInitializationException|ApiException
     */
    public function getByGatewayCode(string $gatewayCode, array $options = []): PaymentMethod
    {
        $options = array_intersect_key($options, self::ALLOWED_OPTIONS);
        $response = $this->client->createGetRequest('json/payment-methods/' . $gatewayCode, $options);
        return new PaymentMethod($response->getResponseData());
    }
}
