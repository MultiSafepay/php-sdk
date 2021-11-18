<?php declare(strict_types=1);
/**
 * Copyright © 2021 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api;

use MultiSafepay\Api\ApiTokens\ApiToken;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class ApiTokenManager
 * @package MultiSafepay\Api
 */
class ApiTokenManager extends AbstractManager
{
    /**
     * @return ApiToken
     * @throws ClientExceptionInterface
     */
    public function get(): ApiToken
    {
        $response = $this->client->createGetRequest(
            'json/auth/api_token'
        );

        return new ApiToken($response->getResponseData());
    }
}
