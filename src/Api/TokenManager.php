<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api;

use MultiSafepay\Api\Tokens\Token;
use MultiSafepay\Api\Tokens\TokenListing;
use MultiSafepay\Exception\ApiException;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class TokenManager
 * @package MultiSafepay\Api
 */
class TokenManager extends AbstractManager
{
    public const CREDIT_CARD_GATEWAYS = ['VISA', 'MASTERCARD', 'AMEX', 'MAESTRO'];
    public const CREDIT_CARD_GATEWAY_CODE = 'CREDITCARD';

    /**
     * @var array
     */
    private $tokens = [];

    /**
     * @param string $reference
     * @param bool $forceApiCall
     * @return array
     * @throws ClientExceptionInterface|ApiException
     */
    public function getList(string $reference, bool $forceApiCall = false): array
    {
        $response = $this->client->createGetRequest('json/recurring/' . $reference);
        if (!isset($this->tokens[$reference]) || $forceApiCall) {
            $this->tokens[$reference] = (new TokenListing($response->getResponseData()['tokens']))->getTokens();
        }
        return $this->tokens[$reference];
    }

    /**
     * @param string $token
     * @param string $reference
     * @return Token
     * @throws ClientExceptionInterface|ApiException
     */
    public function get(string $token, string $reference): Token
    {
        $response = $this->client->createGetRequest('json/recurring/' . $reference . '/token/' . $token);
        return new Token($response->getResponseData());
    }

    /**
     * @param string $token
     * @param string $reference
     * @return bool
     * @throws ClientExceptionInterface|ApiException
     */
    public function delete(string $token, string $reference): bool
    {
        $this->client->createDeleteRequest('json/recurring/' . $reference . '/remove/' . $token);
        return true;
    }

    /**
     * @param string $reference
     * @param string $code
     * @param bool $forceApiCall
     * @return array
     * @throws ClientExceptionInterface|ApiException
     */
    public function getListByGatewayCode(string $reference, string $code, bool $forceApiCall = false): array
    {
        $tokens = [];
        foreach ($this->getList($reference, $forceApiCall) as $token) {
            if ($token->getGatewayCode() === $code) {
                $tokens[] = $token;
                continue;
            }
            if ($code === self::CREDIT_CARD_GATEWAY_CODE
                && in_array($token->getGatewayCode(), self::CREDIT_CARD_GATEWAYS, true)) {
                $tokens[] = $token;
            }
        }

        return $tokens;
    }

    /**
     * Return the tokens as array
     *
     * @param string $reference
     * @param string $code
     * @param bool $forceApiCall
     * @return array
     * @throws ClientExceptionInterface|ApiException
     */
    public function getListByGatewayCodeAsArray(string $reference, string $code, bool $forceApiCall = false): array
    {
        $tokens = [];
        /** @var Token $token */
        foreach ($this->getList($reference, $forceApiCall) as $token) {
            if ($token->getGatewayCode() === $code) {
                $tokens[] = $token->getData();
                continue;
            }
            if ($code === self::CREDIT_CARD_GATEWAY_CODE
                && in_array($token->getGatewayCode(), self::CREDIT_CARD_GATEWAYS, true)) {
                $tokens[] = $token->getData();
            }
        }

        return $tokens;
    }
}
