<?php declare(strict_types=1);
/**
 * Copyright © 2021 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api;

use MultiSafepay\Api\Tokens\Token;
use MultiSafepay\Api\Tokens\TokenListing;

/**
 * Class TokenManager
 * @package MultiSafepay\Api
 */
class TokenManager extends AbstractManager
{
    /**
     * @param string $reference
     * @return Token[]
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function getList(string $reference): array
    {
        $response = $this->client->createGetRequest('recurring/' . $reference);
        return (new TokenListing($response->getResponseData()['tokens']))->getTokens();
    }

    /**
     * @param string $token
     * @param string $reference
     * @return Token
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function get(string $token, string $reference): Token
    {
        $response = $this->client->createGetRequest('recurring/' . $reference . '/token/' . $token);
        return new Token($response->getResponseData());
    }

    /**
     * @param string $token
     * @param string $reference
     * @return bool
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function delete(string $token, string $reference): bool
    {
        $this->client->createDeleteRequest('recurring/' . $reference . '/remove/' . $token);
        return true;
    }

    /**
     * @param string $reference
     * @param string $code
     * @return Token[]
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function getListByGatewayCode(string $reference, string $code): array
    {
        $tokens = $this->getList($reference);
        foreach ($tokens as $key => $token) {
            if ($token->getGatewayCode() === $code) {
                continue;
            }

            if ('CREDITCARD' === $code && in_array($token->getGatewayCode(), array('VISA', 'MASTERCARD', 'AMEX'))) {
                continue;
            }

            unset($tokens[$key]);
        }

        return $tokens;
    }
}
