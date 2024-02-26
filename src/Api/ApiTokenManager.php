<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api;

use MultiSafepay\Api\ApiTokens\ApiToken;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Exception\InvalidDataInitializationException;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class ApiTokenManager
 * @package MultiSafepay\Api
 */
class ApiTokenManager extends AbstractManager
{
    /**
     * @return ApiToken
     * @throws ClientExceptionInterface|InvalidDataInitializationException|ApiException
     */
    public function get(): ApiToken
    {
        $response = $this->client->createGetRequest(
            'json/auth/api_token'
        );

        return new ApiToken($response->getResponseData());
    }
}
