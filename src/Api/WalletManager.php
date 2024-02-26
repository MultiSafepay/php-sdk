<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api;

use MultiSafepay\Api\Wallets\ApplePay\MerchantSession;
use MultiSafepay\Api\Wallets\ApplePay\MerchantSessionRequest;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Exception\InvalidDataInitializationException;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class WalletManager
 * @package MultiSafepay\Api
 */
class WalletManager extends AbstractManager
{
    private const WALLETS_API_URL_PREFIX = 'json/wallets/';

    /**
     * @param MerchantSessionRequest $requestBody
     * @return MerchantSession
     * @throws ClientExceptionInterface|InvalidDataInitializationException|ApiException
     */
    public function createApplePayMerchantSession(MerchantSessionRequest $requestBody): MerchantSession
    {
        $response = $this->client->createPostRequest(
            self::WALLETS_API_URL_PREFIX . 'sessions/applepay',
            $requestBody
        );

        return new MerchantSession($response->getResponseData());
    }
}
